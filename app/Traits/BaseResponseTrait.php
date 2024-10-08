<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

trait BaseResponseTrait
{
    protected ?int $statusCode = null;

    /**
     * setStatusCode() set status code value
     *
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * respondWithArray() used to return json response array with status and headers
     *
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithArray($data, array $headers = []): JsonResponse
    {
        return response()->json($data, $data['status'] ?? 200, $headers);
    }

    /**
     * respondWithView() used to return a Blade view response.
     *
     * @param string $view
     * @param array $data
     * @return View
     */
    protected function respondWithView(string $view, array $data = []): View
    {
        return view($view, $data);
    }

    /**
     * getStatusCode() return status code value
     *
     * @return int
     */
    protected function getStatusCode(): int
    {
        return $this->statusCode ?: Response::HTTP_OK;
    }

    /**
     * respondWithSuccess() used to return success message
     *
     * @param string|null $message
     * @param array $data
     * @return JsonResponse|View
     */
    protected function respondWithSuccess(string $message = null, array $data = []): JsonResponse|View
    {
        $response = [
            'status' => Response::HTTP_OK,
        ];
        $response['message'] = !empty($message) ? $message : __('Success');
        if (!empty($data)) {
            $response['data'] = $data;
        }

        // Check if the request expects a JSON response or a view
        return request()->wantsJson() || request()->ajax()
            ? $this->setStatusCode(Response::HTTP_OK)->respondWithArray($response) 
            : $this->respondWithView($this->viewName, $response); // Specify your success view name
    }

    /**
     * respondWithError() used to return error message
     *
     * @param $message
     * @param int $statusCode
     * @return JsonResponse|View
     */
    protected function respondWithError($message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse|View
    {
        return $this->respondWithErrors($message, $statusCode);
    }

    /**
     * respondWithErrors()
     *
     * @param string $errors
     * @param null $statusCode
     * @param array $data
     * @param null $message
     * @return JsonResponse|View
     */
    protected function respondWithErrors(
        string $errors = 'messages.error',
        $statusCode = null,
        array $data = [],
        $message = null
    ): JsonResponse|View {
        $statusCode = !empty($statusCode) ? $statusCode : Response::HTTP_INTERNAL_SERVER_ERROR;
        if (is_string($errors)) {
            $errors = __($errors);
        }
        $response = ['status' => $statusCode, 'message' => $message, 'errors' => ['message' => [$errors]]];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        if (!empty($data)) {
            $response['data'] = $data;
        }

        // Check if the request expects a JSON response or a view
        return request()->wantsJson() 
            ? $this->setStatusCode($statusCode)->respondWithArray($response) 
            : $this->respondWithView('your.error.view.name', $response); // Specify your error view name
    }

    /**
     * respondWithBoolean() used to determine if process success or failed
     *
     * @param $result
     * @return JsonResponse|View
     */
    protected function respondWithBoolean($result): JsonResponse|View
    {
        return $result ? $this->respondWithSuccess() : $this->errorUnknown();
    }

    /**
     * **************************************************************************
     *                           Response Status Helpers
     * **************************************************************************
     */

    public function errorWrongArgs($message = null): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Wrong Arguments');
        }
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    public function errorUnauthorized($message = null): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Unauthorized');
        }
        return $this->respondWithErrors($message, Response::HTTP_UNAUTHORIZED);
    }

    public function errorForbidden($message = null): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Forbidden');
        }
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    public function errorNotFound($message = null): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Not Found');
        }
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function errorInternalError($message = null): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Internal Server Error');
        }
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function errorUnknown(string $message = 'dashboard.unknown_error'): JsonResponse|View
    {
        if (empty($message)) {
            $message = __('Unknown Error');
        }
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respondWithJson($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
