<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class BulkTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_ids'          => ['required', 'array', 'min:1'],
            'task_ids.*'        => ['integer', 'exists:tasks,id'],

            'action'            => ['required', 'string', 'in:update,delete'],

            'status'            => ['nullable', 'string'],
            'assigned_to'       => ['nullable', 'exists:event_participants,id'],
            'department_id'     => ['nullable', 'exists:departments,id'],
            'deadline'          => ['nullable', 'date'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->action === 'update' && ! $this->hasAny([
                    'status',
                    'assigned_to',
                    'department_id',
                    'deadline',
                ])) {
                $validator->errors()->add(
                    'action',
                    'Для массового обновления нужно передать хотя бы одно поле'
                );
            }
        });
    }
}
