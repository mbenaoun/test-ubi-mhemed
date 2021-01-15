<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Service\CacheService;

/**
 * Class UserDataPersister.
 */
final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var ContextAwareDataPersisterInterface */
    private ContextAwareDataPersisterInterface $decorated;

    /** @var CacheService */
    private CacheService $cacheService;

    /**
     * UserDataPersister constructor.
     *
     * @param ContextAwareDataPersisterInterface $decorated
     * @param CacheService                       $cacheService
     */
    public function __construct(ContextAwareDataPersisterInterface $decorated, CacheService $cacheService)
    {
        $this->decorated = $decorated;
        $this->cacheService = $cacheService;
    }

    /**
     * @param $data
     * @param array $context
     *
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @param $data
     * @param array $context
     *
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        return $this->decorated->persist($data, $context);
    }

    /**
     * @param $data
     * @param array $context
     *
     * @return mixed
     */
    public function remove($data, array $context = [])
    {
        if ($data instanceof User) {
            $this->cacheService->delete('avg-users-' . $data->id);
        }

        return $this->decorated->remove($data, $context);
    }
}
