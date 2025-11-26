<?php

namespace App\Models\Repositories\Trait;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Illuminate\Support\Collection;

trait QueryCacheStrategy
{
    /** @var string $cacheTag */
    private $cacheTag = '';

    /**
     * Appends cache-version and ids to the cacheKey
     * @param array $params
     * @return string
     */
    public function makeKey(array $params = [])
    {

        return md5(json_encode($params));
    }

    /**
     * @param string $cacheKey
     * @return mixed
     */
    public function get(string $cacheKey)
    {
        return $this->getCache()->tags($this->cacheTag)->get($cacheKey);
    }

    /**
     * @param string $cacheKey
     * @param mixed $data
     * @return mixed
     */
    public function put(string $cacheKey, $data)
    {
        return $this->getCache()->tags($this->cacheTag)->forever($cacheKey, $data);
    }

    /**
     * @return mixed
     */
    public function clear(string $cacheKey = null)
    {
        if($cacheKey != null){
            return $this->getCache()->tags($this->cacheTag)->forget($cacheKey);
        }
        else{
            return $this->getCache()->tags($this->cacheTag)->flush();
        }
    }

}
