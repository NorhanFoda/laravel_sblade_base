<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserTokenService
{

    public function createToken($model, $data): mixed
    {
        $apiToken = $model->createToken($data['device_name'] ?? request()?->header('User-Agent'));
        $accessToken = $apiToken->accessToken;
        $accessToken->device_id = $data['device_id'] ?? null;
        $accessToken->device_os = $data['device_name'] ?? null;
        $accessToken->device_os_version = $data['device_os_version'] ?? null;
        $accessToken->app_version = $data['app_version'] ?? null;
        $accessToken->timezone = $data['timezone'] ?? null;
        $accessToken->fcm_token = $data['fcm_token'] ?? null;
        $apiToken->accessToken->save();
        return $apiToken->plainTextToken;
    }

    public function updateToken($attributes, $model)
    {
        $fcm = $model->tokens()->where('fcm_token', $attributes['fcm_token'])->first();
        if (!$fcm) {
            $token = $model->createToken('web', $attributes);
            $token->accessToken->fcm_token = $attributes['fcm_token'];
            $token->accessToken->save();
        }
        return $model->refresh();
    }

    public function loginCheck(array $credentials): string|User
    {
        if (Auth::attempt($credentials)) {
            if (!Auth::user()->is_active) {
                Auth::logout();
                return __('messages.not_active');
            }
            return auth()->user()?->load('roles', 'permissions', 'tokens', 'avatar');
        }
        return __('messages.wrong_credentials');
    }
}
