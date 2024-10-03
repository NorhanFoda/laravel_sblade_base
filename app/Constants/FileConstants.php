<?php

namespace App\Constants;

use App\Traits\ConstantsTrait;

enum FileConstants: string
{
    use ConstantsTrait;
    case FILE_TYPE_USER_AVATAR = 'user_avatar';

    public function getLabels($value):string
    {
        return match ($value) {
            self::FILE_TYPE_USER_AVATAR => 'User Avatar',
            default => 'Unknown'
        };
    }

    public function label(): string
    {
        return self::getLabels($this);
    }
}
