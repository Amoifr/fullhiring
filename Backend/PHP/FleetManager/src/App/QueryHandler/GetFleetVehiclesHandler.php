<?php

namespace Fulll\App\QueryHandler;

use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\Domain\Entity\Vehicle;

class GetFleetVehiclesHandler
{
    /**
     * @param GetFleetVehiclesQuery $query
     * @return Vehicle[]
     */
    public function handle(GetFleetVehiclesQuery $query): array
    {
        return $query->getFleet()->getVehicles();
    }
}
