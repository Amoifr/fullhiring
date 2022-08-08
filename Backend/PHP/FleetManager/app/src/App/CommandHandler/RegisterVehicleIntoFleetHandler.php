<?php

declare(strict_types=1);

namespace Fulll\App\CommandHandler;

use Exception;
use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\Infra\CommandHandlerInterface;

class RegisterVehicleIntoFleetHandler implements CommandHandlerInterface
{
    /**
     * @throws Exception
     */
    public function __invoke(RegisterVehicleIntoFleetCommand $command): void
    {
        try {
            $command->getFleet()->addVehicle($command->getVehicle());
        } catch (Exception $e) {
            throw new Exception('Could not add vehicle to fleet');
        }
    }
}
