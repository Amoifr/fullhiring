<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Fulll\App\Repository\VehicleRepository;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\Table(name: 'vehicle')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'json')]
    private ?array $location = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $plateNumber = null;

    #[ORM\ManyToOne(targetEntity: Fleet::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fleet $fleet = null;

    /**
     * @return ?Location
     */
    public function getLocation(): ?Location
    {
        return new Location($this->location['latitude'], $this->location['longitude']);
    }

    /**
     * @throws Exception
     */
    public function setLocation(Location $location): void
    {
        if (null === $this->location || !$this->locationIsSameAsCurrent($location)) {
            $this->location = [
                'latitude' => $location->getLatitude(),
                'longitude' => $location->getLongitude(),
            ];
        } else {
            throw new Exception('Vehicle is already parked at this location');
        }
    }

    private function locationIsSameAsCurrent(Location $location): bool
    {
        return $this->location['latitude'] === $location->getLatitude() && $this->location['longitude'] === $location->getLongitude();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet): self
    {
        $this->fleet = $fleet;

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(?string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }
}
