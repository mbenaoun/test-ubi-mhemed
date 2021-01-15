<?php

namespace App\Service;

use App\Entity\Notation;
use App\Repository\NotationRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class NotationService
 * @package App\Service
 */
class NotationService
{
    /** @var NotationRepository */
    private NotationRepository $notationRepository;

    /** @var CacheService */
    private CacheService $cacheService;

    /**
     * NotationService constructor.
     * @param EntityManagerInterface $entityManager
     * @param CacheService $cacheService
     */
    public function __construct(EntityManagerInterface $entityManager, CacheService $cacheService)
    {
        $this->notationRepository = $entityManager->getRepository(Notation::class);
        $this->cacheService = $cacheService;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getAvgUser(int $userId)
    {
        $result = $this->cacheService->getValue('avg-users-' . $userId);

        if (null === $result) {
            $avgUser = $this->notationRepository->findAvgUser($userId);
            $result = [];

            if (!empty($avgUser)) {
                $result['avg'] = 0;
                foreach ($avgUser as $anAvg) {
                    $result['avg'] += $anAvg['avg'];
                }

                $result['avg'] = $result['avg'] / count($avgUser);
            }

            $this->cacheService->setValue('avg-users-'. $userId, $result);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAvgUsers(): array
    {
        $usersHaveNotation = $this->notationRepository->findUsersHaveNotation();

        $result = [];

        if (!empty($usersHaveNotation)) {
            $result['avg'] = 0;
            foreach ($usersHaveNotation as $userHaveNotation) {
                $result['avg'] += $this->getAvgUser($userHaveNotation['id'])['avg'] ?? 0;
            }

            $result['avg'] = $result['avg'] / count($usersHaveNotation);
        }

        return $result;
    }
}