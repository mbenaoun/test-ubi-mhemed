<?php

namespace App\Repository;

use App\Entity\Notation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Notation find($id, $lockMode = null, $lockVersion = null)
 * @method null|Notation findOneBy(array $criteria, array $orderBy = null)
 * @method Notation[]    findAll()
 * @method Notation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notation::class);
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function findAvgUser(int $userId): array
    {
        return $this->createQueryBuilder('n')
            ->select('n.subject, avg(n.score) as avg')
            ->where('n.user = :userId')
            ->setParameter('userId', $userId)
            ->groupBy('n.subject')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * @return array
     */
    public function findUsersHaveNotation(): array
    {
        return $this->createQueryBuilder('n')
            ->distinct()
            ->select('u.id')
            ->join('n.user', 'u')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
