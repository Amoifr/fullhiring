<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Fulll\App\Query\GetVehicleLocationQuery;
use Fulll\Domain\Entity\Location;
use Fulll\Infra\QueryHandlerInterface;

class GetVehicleLocationHandler implements QueryHandlerInterface
{
    public function __invoke(GetVehicleLocationQuery $query): Location
    {
        return $query->getVehicle()->getLocation();
    }
}
