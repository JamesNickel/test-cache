<?php

namespace App\Models\Resources;

use App\Models\Entities\Cache;
use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Eghamat24\DatabaseRepository\Models\Resources\Resource;

class CacheResource extends Resource
{
    public function toArray($cache): array
    {
        return [
            'key' => $cache->key,
			'value' => $cache->value,
			'expiration' => $cache->expiration,
			
        ];
    }

    public function toArrayWithForeignKeys($cache): array
    {
        return $this->toArray($cache) + [
            
        ];
    }
}
