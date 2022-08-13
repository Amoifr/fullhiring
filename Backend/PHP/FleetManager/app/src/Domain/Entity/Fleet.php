<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Fulll\App\Repository\FleetRepository;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
#[ORM\Table(name: 'fleet')]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToMany(mappedBy: 'fleet', targetEntity: Vehicle::class, orphanRemoval: true)]
    private Collection $vehicles;

    #[ORM\OneToOne(inversedBy: 'fleet', targetEntity: User::class)]
    private User $user;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    /**
     * @throws Exception
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
        } else {
            throw new Exception('Vehicle is already in fleet');
        }
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
