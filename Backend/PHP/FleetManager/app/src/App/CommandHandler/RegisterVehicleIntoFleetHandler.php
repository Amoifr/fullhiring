<?php

declare(strict_types=1);

namespace Fulll\App\CommandHandler;

use Exception;
use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\App\Repository\FleetRepository;
use Fulll\Infra\MessengerBus\CommandHandlerInterface;

class RegisterVehicleIntoFleetHandler implements CommandHandlerInterface
{
    private FleetRepository $fleetRepository;

    public function __construct(
        FleetRepository $fleetRepository
    ) {
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(RegisterVehicleIntoFleetCommand $command): void
    {
        try {
            $command->getFleet()->addVehicle($command->getVehicle());
            $this->fleetRepository->save($command->getFleet());
        } catch (Exception $e) {
            throw new Exception('Could not add vehicle to fleet');
        }
    }
}
