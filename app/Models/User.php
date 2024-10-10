<?php

namespace App\Models;

use App\Constants\FileConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait,
        HasRoles, SearchTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country_code',
        'is_active',
        'need_logout'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected array $filters = ['keyword', 'role', 'roleName', 'email', 'isActiveEmployee'];
    public array $filterModels = ['Role'];
    public array $filterCustom = [];
    protected array $searchable = ['name', 'email'];

    //---------------------relations-------------------------------------

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', FileConstants::FILE_TYPE_USER_AVATAR)->latest();
    }

    //---------------------relations-------------------------------------

    // ----------------------- Scopes -----------------------
    public function scopeOfRole($query, $value)
    {
        return $query->whereHas('roles', function ($query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function scopeOfRoleName($query, $value)
    {
        $value = (array) $value;

        return $query->whereHas('roles', function ($query) use ($value) {
            $query->whereIn('name', $value);
        });
    }

    // ----------------------- Scopes -----------------------

    // --------------------- custom filters data -------------------

    // --------------------- custom filters data -------------------

    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function routeNotificationForFcm(): array|string
    {
        return $this->getDeviceTokens();
    }

    public function getDeviceTokens(): array
    {
        return $this->tokens->whereNotNull('fcm_token')->unique('fcm_token')->pluck('fcm_token')->toArray();
    }

    // ---------------------------------------Attributes---------------------------------------
    public function getRoleIdAttribute()
    {
        return $this->roles->last()?->id;
    }
}

