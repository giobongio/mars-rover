<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'x' => 'required|integer|gte:0',
            'y' => 'required|integer|gte:0',
            'direction' => 'required|string|max:1',
        ];
    }
}
