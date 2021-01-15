<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class User
 * @package App\Entity
 * @ApiResource(
 *     itemOperations={
 *          "GET",
 *          "DELETE",
 *          "PATCH",
 *          "avg_users"={
 *              "method"="GET",
 *              "path"="/users/{userId}/avg",
 *              "swagger_context"={
 *                  "summary"="Avg User",
 *                  "parameters"={},
 *              }
 *          }
 *     },
 *     collectionOperations={"POST"},
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    #region Attributes
    /**
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @Groups("user:read")
     */
    public ?int $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"user:read", "user:write"})
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"user:read", "user:write"})
     */
    public string $firstName;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read", "user:write"})
     */
    public DateTimeInterface $dateOfBirth;

    /**
     * @ORM\OneToMany(targetEntity=Notation::class, mappedBy="user", orphanRemoval=true)
     * @Groups("user:read")
     */
    public Collection $notations;
    #endregion

    #region Constructor
    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->notations = new ArrayCollection();
    }
    #endregion

    #region Methods Notations Collection
    /**
     * @param Notation $notation
     * @return $this
     */
    public function addNotation(Notation $notation): self
    {
        if (!$this->notations->contains($notation)) {
            $this->notations[] = $notation;
            $notation->user = $this;
        }

        return $this;
    }

    /**
     * @param Notation $notation
     * @return $this
     */
    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->removeElement($notation)) {
            if ($notation->user === $this) {
                $notation->user = null;
            }
        }

        return $this;
    }
    #endregion
}
