<?php

declare(strict_types=1);

namespace Fulll\Infra\ErrorStack\ErrorDTO;

use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;

class AlreadyParkAtThisLocationErrorDTO implements ErrorDTOInterface
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
