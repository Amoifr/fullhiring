<?php

namespace Fulll\App\Query;

use Fulll\App\CommandInterface;
use Fulll\Domain\Entity\Vehicle;

class GetVehicleLocationQuery implements CommandInterface
{
    private Vehicle $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
}
