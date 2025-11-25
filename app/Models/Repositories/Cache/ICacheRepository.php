<?php

namespace App\Models\Repositories\Cache;

use App\Models\Entities\Cache;
use Illuminate\Support\Collection;

interface ICacheRepository
{
    public function getOneById(int $id): null|Cache;

    public function getAllByIds(array $ids): Collection;

}