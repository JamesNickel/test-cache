<?php

namespace App\Models\Repositories\Cache;

use App\Models\Entities\Cache;
use App\Models\Factories\CacheFactory;
use Illuminate\Support\Collection;
use Eghamat24\DatabaseRepository\Models\Repositories\MySqlRepository;

class MySqlCacheRepository extends MySqlRepository implements ICacheRepository
{
    public function __construct()
    {
        $this->table = 'cache';
        $this->primaryKey = 'id';
        $this->softDelete = false;
        $this->factory = new CacheFactory();

        parent::__construct();
    }

    public function getOneById(int $id): null|Cache
    {
        $cache = $this->newQuery()
            ->where('id', $id)
            ->first();

        return $cache ? $this->factory->makeEntityFromStdClass($cache) : null;
    }

    public function getAllByIds(array $ids): Collection
    {
        $cache = $this->newQuery()
            ->whereIn('id', $ids)
            ->get();

        return $this->factory->makeCollectionOfEntities($cache);
    }

    public function create(Cache $cache): Cache
    {
    	

        $id = $this->newQuery()
            ->insertGetId([
                'key' => $cache->key,
				'value' => $cache->value,
				'expiration' => $cache->expiration,
            ]);

        $cache->id = $id;

        return $cache;
    }

    public function update(Cache $cache): int
    {
    	

        return $this->newQuery()
           ->where($this->primaryKey, $cache->getPrimaryKey())
            ->update([
                'key' => $cache->key,
				'value' => $cache->value,
				'expiration' => $cache->expiration,
            ]);
    }
}
