<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NotationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Notation
 * @package App\Entity
 * @ApiResource(
 *     itemOperations={"GET"},
 *     collectionOperations={
 *          "POST",
 *          "notations_users"={
 *              "method"="GET",
 *              "path"="/notations/avg",
 *              "swagger_context"={
 *                  "summary"="Avg Users",
 *                  "parameters"={},
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=NotationRepository::class)
 */
class Notation
{
    #region Attributes
    /**
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    public int $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    public string $subject;

    /**
     * @Assert\Range(min="0", max="20")
     * @ORM\Column(type="float", options={"unsigned":true})
     */
    public float $score;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notations")
     * @ORM\JoinColumn(nullable=false)
     */
    public ?User $user;
    #endregion
}
