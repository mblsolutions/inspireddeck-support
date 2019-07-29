<?php

namespace MBLSolutions\InspiredDeckSupport\Repositories;

use InspiredDeckAuth;

abstract class UserCacheRepository extends CachedRepository
{

    /**
     * User Cache Repository
     */
    public function __construct()
    {
        $this->cachePrefix = md5(InspiredDeckAuth::getEmail());
    }

}