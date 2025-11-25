<?php

namespace App\Models\Repositories\Trait;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Illuminate\Support\Collection;

trait QueryCacheStrategy
{
    /** @var string $cacheTag */
    private $cacheTag = '';
    private $idSeparator = '___';

    /**
     * @param array $params
     * @return string
     */
    public function makeKey(array $params = [])
    {
        $params['_v'] = $this->getCacheVersion();

        $identifiers = is_array($params['id']) ? $params['id'] : [$params['id']];

        return md5(json_encode($params)) . $this->idSeparator . json_encode($identifiers);
    }

    /**
     * @param string $cacheKey
     * @return mixed
     */
    public function get(string $cacheKey)
    {
        //return $this->getCache()->tags($this->cacheTag)->get($cacheKey);
        return $this->getByIndexKey($cacheKey);
    }

    /**
     * @param string $cacheKey
     * @param mixed $data
     * @return mixed
     */
    public function put(string $cacheKey, $data)
    {
        $cache = $this->getCache()->tags($this->cacheTag);

        //$cache->forever($cacheKey, $data);

        if ($data instanceof Entity) {
            $this->putByIndexKey($cache, $cacheKey, $data);
        }

        if ($data instanceof Collection) {
            foreach ($data as $entity) {
                if ($entity instanceof Entity) {
                    $this->putByIndexKey($cache, $cacheKey, $entity);
                }
            }
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function clear()
    {
        //return $this->getCache()->tags($this->cacheTag)->flush();
        return $this->bumpCacheVersion();
    }

    public function putByIndexKey($cache, string $cacheKey, Entity $data){

        $indexKey = $this->makeEntityIndexKey($cacheKey, $data->getPrimaryKey());
        $cache->forever($indexKey, $data);
    }

    public function getByIndexKey($cacheKey){
        $cacheKeyParts = explode($this->idSeparator, $cacheKey);
        $identifiers = [];
        if(count($cacheKeyParts) > 1){
            $identifiers = json_decode($cacheKeyParts[1]);
        }
        $indexKeys = [];
        foreach($identifiers as $primaryKey){
            $indexKeys[] = $this->makeEntityIndexKey($cacheKey, $primaryKey);
        }
        return $this->getCache()->tags($this->cacheTag)->get($indexKeys);
    }


    /**
     * @param int $primaryKey
     * @return string
     */
    protected function makeEntityIndexKey(string $cacheKey, int $primaryKey): string
    {
        return $this->cacheTag.':'.$cacheKey . ':entity:' . $primaryKey;
    }

    /**
     * @return string
     */
    protected function getCacheVersionKey(): string
    {
        return $this->cacheTag . ':version';
    }

    /**
     *
     * @return int
     */
    protected function getCacheVersion(): int
    {
        $store   = $this->getCache()->tags($this->cacheTag);
        $key     = $this->getCacheVersionKey();
        $version = $store->get($key);

        if (!is_int($version) || $version < 1) {
            $version = 1;
            $store->forever($key, $version);
        }

        return $version;
    }

    /**
     * @return int
     */
    protected function bumpCacheVersion(): int
    {
        $store = $this->getCache()->tags($this->cacheTag);
        $key   = $this->getCacheVersionKey();

        if (!$store->has($key)) {
            $store->forever($key, 1);

            return 1;
        }

        return (int) $store->increment($key);
    }
}
