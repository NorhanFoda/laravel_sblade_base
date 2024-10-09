<?php

namespace App\Repositories\SQL;

use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RoleContract;

class RoleRepository extends BaseRepository implements RoleContract
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = []): mixed
    {
        $role = parent::create($attributes);
        $role = $this->syncPermissions($role, $attributes);
        return $role->refresh();
    }

    public function update($model, array $attributes = []): mixed
    {
        $role = parent::update($model, $attributes);
        $role = $this->syncPermissions($role, $attributes);
        return $role->refresh();
    }

    public function syncPermissions($model, array $attributes = []): mixed
    {
        $requestPermissions = $attributes['role_permissions']?
            array_filter(Arr::flatten(array_values($attributes['role_permissions']))) :[];
        $model->syncPermissions($requestPermissions);
        return $model->refresh();
    }

    public function roleCanBeDeleted($role): bool
    {
        $role->load('users');
        if (count($role->users) === 0) return true;
        if ($role->can_be_delete) return true;
        return false;
    }

}
