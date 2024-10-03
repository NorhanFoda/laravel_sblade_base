<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if(empty($this->token)){
            return $this->sendMail();
        }else{
            return $this->resetPassword();
        }
    }

    /**
     * @return array
     */
    private function sendMail():array{
        return[
            'email'=> 'required|email|exists:users',
        ];
    }

    /**
     * @return array
     */
    private function resetPassword():array{
        return[
            'email'=> 'required|email|exists:'.config('auth.passwords.users.table'),
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'token' => 'required|string|min:8',
        ];
    }
}
