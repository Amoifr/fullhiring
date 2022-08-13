<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Exception;
use Fulll\App\Query\GetFleetByIdQuery;
use Fulll\App\Repository\FleetRepository;
use Fulll\Domain\Entity\Fleet;
use Fulll\Infra\MessengerBus\QueryHandlerInterface;

class GetFleetByIdHandler implements QueryHandlerInterface
{
    private FleetRepository $fleetRepository;

    public function __construct(
        FleetRepository $fleetRepository
    ) {
        $this->fleetRepository = $fleetRepository;
    }

    public function __invoke(GetFleetByIdQuery $query): Fleet
    {
        $fleet = $this->fleetRepository->findOneById($query->getFleetId());
        if (null === $fleet) {
            throw new Exception('Fleet not found');
        }

        return $fleet;
    }
}
