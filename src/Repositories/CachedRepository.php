<?php

namespace MBLSolutions\InspiredDeckSupport\Repositories;

use Illuminate\Support\Facades\Cache;

abstract class CachedRepository
{
    /** @var string $cachePrefix */
    protected $cachePrefix;

    /** @var int $ttl */
    protected $ttl = 3600;

    /**
     * Put an item in the Cache
     *
     * @param $key
     * @param $data
     * @return bool
     */
    public function put($key, $data)
    {
        return Cache::put($this->cachePrefix . $key, $data, $this->ttl);
    }

    /**
     * Get an item from the Cache
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Cache::get($this->cachePrefix . $key, $default);
    }

    /**
     * Get the repository model
     *
     * @return mixed
     */
    abstract protected function model();

}