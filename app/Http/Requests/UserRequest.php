<?php

namespace App\Http\Requests;

use App\Traits\JsonValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use JsonValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this['role_id'] = (int)$this['role_id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => config('validations.string.req'),
            'email' => sprintf(config('validations.email.req'), 'users', 'email', $this->user?->id),
            'role_id' => sprintf(config('validations.model.req'), 'roles'),
            // 'user_avatar' => sprintf(config('validations.model.null'), 'files'),
        ];
        match ($this->method()) {
            'POST' => $rules['password'] = config('validations.password.req'),
            'PUT', 'PATCH' => $rules['password'] = config('validations.password.null'),
        };
        return $rules;
    }

    /**
     * Customizing input names displayed for user
     * @return array
     */
    public function attributes(): array
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}
