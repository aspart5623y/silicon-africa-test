<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'exists:profiles,email', 'max:191'],
            'password' => ['required', 'string']
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseHelper::errorWithMessageAndData(
                'validation failed',
                $validator->errors(),
                UNPROCESSABLE_ENTITY
            )
        );
    }
}
