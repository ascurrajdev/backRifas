<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRaffleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'min_number' => ['required','numeric'],
            'max_number' => ['required','numeric'],
            'user_id' => ['required','exists:users,id']
        ];
    }
}
