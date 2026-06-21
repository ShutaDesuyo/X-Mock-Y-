<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('post')->user_id;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:280'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120', 'dimensions:max_width=4096,max_height=4096'],
        ];
    }
}
