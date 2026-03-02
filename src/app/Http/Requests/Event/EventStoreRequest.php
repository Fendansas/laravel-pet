<?php

namespace App\Http\Requests\Event;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventStoreRequest extends FormRequest
{

    // Останавливаемся на первой ошибке
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('create', Event::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->name ? trim($this->name): null,
            'description' => $this->description ? trim($this->description): null,
        ]);
    }

    public function attributes(): array
    {
        return [
            'name'        => 'название события',
            'description' => 'описание',
            'start_date'  => 'дата начала',
            'end_date'    => 'дата окончания',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название события обязательно',
            'name.max' => 'Название события не должно превышать 255 символов',

            'end_date.after_or_equal' =>
                'Дата окончания не может быть раньше даты начала',
        ];
    }
    // проверяем чтоб дата начала не была равна дате окончнияю
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {

            if (
                $this->filled('start_date') &&
                $this->filled('end_date') &&
                strtotime($this->start_date) === strtotime($this->end_date)
            ) {
                $validator->errors()->add(
                    'end_date',
                    'Дата окончания не должна совпадать с датой начала'
                );
            }

        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Ошибка валидации',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function validatedData(): array
    {
        return $this->safe()->only([
            'name',
            'description',
            'start_date',
            'end_date',
        ]);
    }
}
