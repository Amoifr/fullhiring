<?php

namespace Fulll\Infra\ErrorDTO;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;

class AlreadyPresentVehicleInFleetErrorDTO implements ErrorDTOInterface
{
    private Vehicle $vehicle;
    private Fleet $fleet;

    public function __construct(Vehicle $vehicle, Fleet $fleet)
    {
        $this->vehicle = $vehicle;
        $this->fleet = $fleet;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }
}
