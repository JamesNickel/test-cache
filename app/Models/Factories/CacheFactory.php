<?php

namespace App\Models\Factories;

use App\Models\Entities\Cache;
use Eghamat24\DatabaseRepository\Models\Factories\Factory;
use stdClass;

class CacheFactory extends Factory
{
    public function makeEntityFromStdClass(stdClass $entity): Cache
    {
        $cache = new Cache();

        $cache->key = $entity->key;
		$cache->value = $entity->value;
		$cache->expiration = $entity->expiration;
		
        return $cache;
    }
}
