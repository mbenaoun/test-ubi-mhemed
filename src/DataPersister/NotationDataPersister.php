<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Notation;
use App\Service\CacheService;

/**
 * Class NotationDataPersister
 * @package App\DataPersister
 */
final class NotationDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var ContextAwareDataPersisterInterface */
    private ContextAwareDataPersisterInterface $decorated;

    /** @var CacheService */
    private CacheService $cacheService;

    /**
     * NotationDataPersister constructor.
     * @param ContextAwareDataPersisterInterface $decorated
     * @param CacheService $cacheService
     */
    public function __construct(ContextAwareDataPersisterInterface $decorated, CacheService $cacheService)
    {
        $this->decorated = $decorated;
        $this->cacheService = $cacheService;
    }

    /**
     * @param $data
     * @param array $context
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @param $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        $result = $this->decorated->persist($data, $context);

        if (
            $data instanceof Notation && (
                ($context['collection_operation_name'] ?? null) === 'POST' ||
                ($context['graphql_operation_name'] ?? null) === 'CREATE'
            )
        ) {
            $this->cacheService->delete('avg-users-' . $data->user->id);
        }

        return $result;
    }

    /**
     * @param $data
     * @param array $context
     * @return mixed
     */
    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}