<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\RegisterVehicleIntoFleetCommand;

class RegisterVehicleIntoFleetHandler
{
    public function handle(RegisterVehicleIntoFleetCommand $command): void
    {
        try {
            $command->getFleet()->addVehicle($command->getVehicle());
        } catch (\Exception $e) {
            throw new \Exception('Could not add vehicle to fleet');
        }
    }
}
