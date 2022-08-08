<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

use Exception;

class Fleet
{
    /**
     * @var Vehicle[]
     */
    private array $vehicles = [];

    /**
     * @throws Exception
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        if (!in_array($vehicle, $this->vehicles)) {
            $this->vehicles[] = $vehicle;
        } else {
            throw new Exception('Vehicle is already in fleet');
        }
    }

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }
}
