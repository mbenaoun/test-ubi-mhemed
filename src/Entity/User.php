<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity
 * @ApiResource(
 *     itemOperations={"patch","delete","post"},
 *     collectionOperations={"post"}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    public int $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=150)
     */
    public string $firstName;

    /**
     * @ORM\Column(type="date")
     */
    public DateTimeInterface $dateOfBirth;
}
