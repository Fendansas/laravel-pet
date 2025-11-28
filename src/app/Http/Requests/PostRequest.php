<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date|after_or_equal:now',
        ];

        if ($this->method() == 'POST') {
            $rules['topic_id'] = 'required|exists:topics,id';
            $rules['status'] = 'required|in:draft,published';
        } else {
            $rules['topic_id'] = 'required|exists:topics,id' . $this->route('post')->id;
            $rules['status'] = 'required|in:draft,published' . $this->route('post')->id;
        }
        return $rules;
    }
}
