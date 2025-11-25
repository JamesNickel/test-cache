<?php

namespace App\Models\Repositories\Post;

use Eghamat24\DatabaseRepository\Models\Repositories\RedisRepository;
use App\Models\Repositories\Trait\QueryCacheStrategy;

class RedisPostRepository extends RedisRepository
{
    use QueryCacheStrategy;

    public function __construct()
    {
        $this->cacheTag = 'posts';
        parent::__construct();
    }
}
