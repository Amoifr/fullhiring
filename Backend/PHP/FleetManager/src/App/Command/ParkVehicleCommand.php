<?php

namespace Fulll\App\Command;

use Fulll\App\CommandInterface;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;

class ParkVehicleCommand implements CommandInterface
{
    private Vehicle $vehicle;
    private Location $location;

    public function __construct(Vehicle $vehicle, Location $location)
    {
        $this->vehicle = $vehicle;
        $this->location = $location;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
