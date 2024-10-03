<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $this->micro = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        $this->mini = [
            'email' => $this->email,
            'phone' => $this->phone,
        ];
        $this->full = [
            $this->mergeWhen(isset($this->api_token), [
                'token' => $this->api_token,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        $this->relations = [
            "role_id" => $this->getLastRoleId(),
            'roles' => $this->relationLoaded('roles') && $this->roles ?
                strtolower(implode(' ,', $this->getRoleNames()->toArray())) : '',
            'permissions' => $this->relationLoaded('permissions') && $this->permissions ?
                PermissionResource::collection($this->getAllPermissions()) : null,
            'fcm_tokens' => $this->relationLoaded('tokens') ? $this->getDeviceTokens() : null,
            'avatar' => $this->relationLoaded('avatar') ? new FileResource($this->avatar) : null,
        ];
        return $this->getResource();
    }

    public function getLastRoleId()
    {
        return $this->roles->last()?->id;
    }
}
