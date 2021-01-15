<?php

namespace App\Service;

use Predis\Client;

/**
 * Class CacheService
 * @package App\Service
 */
class CacheService
{
    /** @var Client */
    private Client $cache;

    /** @var bool */
    private bool $disableCache;

    /**
     * CacheService constructor.
     * @param Client $redisClient
     * @param int $disableCache
     */
    public function __construct(Client $redisClient, int $disableCache)
    {
        $this->cache = $redisClient;
        $this->disableCache = (bool)$disableCache;

    }

    /**
     * @param string $keyName
     * @return mixed|null
     */
    public function getValue(string $keyName)
    {
        $data = $this->cache->get($keyName);

        if (null !== $data) {
            unserialize($data);
        }

        return $this->disableCache ? null : unserialize($data);
    }

    /**
     * @param string $keyName
     * @param $value
     * @return bool
     */
    public function setValue(string $keyName, $value): bool
    {
        if ($this->disableCache) {
            return false;
        }
        $this->cache->set($keyName, serialize($value));

        if (null === $this->cache->get($keyName)) {
            return true;
        }

        return false;
    }
}