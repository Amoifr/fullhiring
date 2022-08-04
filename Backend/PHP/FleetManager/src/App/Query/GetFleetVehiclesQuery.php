<?php

namespace Fulll\App\Query;

use Fulll\App\CommandInterface;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Vehicle;

class GetFleetVehiclesQuery implements CommandInterface
{
    private Fleet $fleet;

    public function __construct(Fleet $fleet)
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }
}
