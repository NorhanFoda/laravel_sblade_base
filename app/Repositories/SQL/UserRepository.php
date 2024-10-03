<?php

namespace App\Repositories\SQL;

use App\Constants\FileConstants;
use App\Models\User;
use App\Repositories\Contracts\FileContract;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserContract
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function syncRelations($model, $attributes): void
    {
        if (isset($attributes['role_id'])) {
            $model->syncRoles($attributes['role_id']);
        }
        if (isset($attributes['user_avatar'])) {
            $model->avatar()->delete();
            $file = resolve(FileContract::class)->find($attributes['user_avatar']);
            $model->avatar()->save($file);
        }
    }

}
