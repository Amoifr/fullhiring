<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

class Vehicle
{
    private ?Location $location = null;

    public function __construct()
    {
    }

    /**
     * @return Location
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     * @throws \Exception
     */
    public function setLocation(Location $location): void
    {
        if ($this->location === null || $this->locationIsDifferentAsCurrent($location)) {
            $this->location = $location;
        } else {
            throw new \Exception('Vehicle is already parked at this location');
        }
    }

    private function locationIsDifferentAsCurrent(Location $location): bool
    {
        return $this->location->getLatitude() !== $location->getLatitude() || $this->location->getLongitude() !== $location->getLongitude();
    }
}
