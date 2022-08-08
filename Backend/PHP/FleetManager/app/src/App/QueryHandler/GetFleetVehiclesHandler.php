<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\QueryHandlerInterface;

class GetFleetVehiclesHandler implements QueryHandlerInterface
{
    /**
     * @return Vehicle[]
     */
    public function __invoke(GetFleetVehiclesQuery $query): array
    {
        return $query->getFleet()->getVehicles();
    }
}
