<?php

namespace Fulll\App\QueryHandler;

use Fulll\App\Query\GetVehicleLocationQuery;
use Fulll\Domain\Entity\Location;

class GetVehicleLocationHandler
{
    public function handle(GetVehicleLocationQuery $query): Location
    {
        return $query->getVehicle()->getLocation();
    }
}
