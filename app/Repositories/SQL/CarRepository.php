<?php

namespace App\Repositories\SQL;

use App\Models\Car;
use App\Repositories\Contracts\CarContract;

class CarRepository extends BaseRepository implements CarContract
{
    /**
     * CarRepository constructor.
     * @param Car $model
     */
    public function __construct(Car $model)
    {
        parent::__construct($model);
    }
}
