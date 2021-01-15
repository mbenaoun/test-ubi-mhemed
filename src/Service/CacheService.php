<?php

namespace App\Service;

use Predis\Client;

/**
 * Class CacheService.
 */
class CacheService
{
    /** @var Client */
    private Client $cache;

    /** @var bool */
    private bool $disableCache;

    /**
     * CacheService constructor.
     *
     * @param Client $redisClient
     * @param int    $disableCache
     */
    public function __construct(Client $redisClient, int $disableCache)
    {
        $this->cache = $redisClient;
        $this->disableCache = (bool) $disableCache;
    }

    /**
     * @param string $keyName
     *
     * @return null|mixed
     */
    public function getValue(string $keyName)
    {
        if ($this->disableCache) {
            return null;
        }

        $data = $this->cache->get($keyName);
        if (null !== $data) {
            return unserialize($data);
        }

        return null;
    }

    /**
     * @param string $keyName
     * @param $value
     *
     * @return bool
     */
    public function setValue(string $keyName, $value): bool
    {
        if ($this->disableCache) {
            return false;
        }
        $this->cache->set($keyName, serialize($value));

        if (null !== $this->cache->get($keyName)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function delete(string $keyName): bool
    {
        if ($this->disableCache) {
            return false;
        }

        $this->cache->del($keyName);

        if (null === $this->cache->get($keyName)) {
            return true;
        }

        return false;
    }
}
