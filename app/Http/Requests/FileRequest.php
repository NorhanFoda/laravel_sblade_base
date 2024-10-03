<?php

namespace App\Http\Requests;

use App\Constants\FileConstants;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|'.$this->getTypeValidation().'|max:5120',
            'type' => 'required|string|in:'.implode(',', FileConstants::values()),
        ];
    }

    public function getTypeValidation(): string|null
    {
        $mixed = $this->accept ?
            config('validations.file.mixed').','.str_replace('.','',$this->accept)
            : config('validations.file.mixed');
        return match(request('type')){
            FileConstants::FILE_TYPE_USER_AVATAR->value,
            => config('validations.file.image'),
            default => $mixed
        };
    }

    public function messages(): array
    {
        return [
            'file.max' => __('File size must not exceed 20 MB')
        ];
    }
}
