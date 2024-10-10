<?php

namespace App\Repositories\SQL;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationContract;

class NotificationRepository extends BaseRepository implements NotificationContract
{
    /**
     * NotificationRepository constructor.
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }
}
