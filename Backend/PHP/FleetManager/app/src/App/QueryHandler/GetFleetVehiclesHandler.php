<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Doctrine\Common\Collections\Collection;
use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\MessengerBus\QueryHandlerInterface;

class GetFleetVehiclesHandler implements QueryHandlerInterface
{
    /**
     * @return Collection<int, Vehicle>
     */
    public function __invoke(GetFleetVehiclesQuery $query): Collection
    {
        return $query->getFleet()->getVehicles();
    }
}
