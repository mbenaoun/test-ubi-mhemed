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

    /**
     * NotationService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->notationRepository = $entityManager->getRepository(Notation::class);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getAvgUser(int $userId): array
    {
        $avgUser = $this->notationRepository->findAvgUser($userId);

        $result = [];

        if (!empty($avgUser)) {
            $result['avg'] = 0;
            foreach ($avgUser as $anAvg) {
                $result['avg'] += $anAvg['avg'];
            }

            $result['avg'] = $result['avg'] / count($avgUser);
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