<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Exception;
use Fulll\App\Query\GetVehicleByPlateNumberQuery;
use Fulll\App\Repository\VehicleRepository;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\MessengerBus\QueryHandlerInterface;

class GetVehicleByPlateNumberHandler implements QueryHandlerInterface
{
    private VehicleRepository $vehicleRepository;

    public function __construct(
        VehicleRepository $vehicleRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function __invoke(GetVehicleByPlateNumberQuery $query): Vehicle
    {
        $vehicle = $this->vehicleRepository->findOneByPlateNumber($query->getPlateNumber());
        if (null === $vehicle) {
            throw new Exception('Vehicle not found');
        }

        return $vehicle;
    }
}
