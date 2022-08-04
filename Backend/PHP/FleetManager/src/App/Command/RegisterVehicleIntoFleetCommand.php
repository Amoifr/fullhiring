<?php

namespace Fulll\App\Command;

use Fulll\App\CommandInterface;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Vehicle;

class RegisterVehicleIntoFleetCommand implements CommandInterface
{
    private Fleet $fleet;
    private Vehicle $vehicle;

    public function __construct(Fleet $fleet, Vehicle $vehicle)
    {
        $this->fleet = $fleet;
        $this->vehicle = $vehicle;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
}
