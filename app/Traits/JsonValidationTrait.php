<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait JsonValidationTrait
{
    use BaseResponseTrait;

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        // Check if the request expects a JSON response or is an AJAX request
        if (request()->wantsJson() || request()->ajax()) {
            throw new HttpResponseException(response()->json([
                'status' => 422,
                'message' => __('The given data was invalid'),
                'errors' => $errors,
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY));
        }

        // If not JSON or AJAX request, fall back to default validation handling
        parent::failedValidation($validator);
    }
}
