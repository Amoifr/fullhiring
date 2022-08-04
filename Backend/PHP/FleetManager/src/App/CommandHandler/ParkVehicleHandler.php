<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\ParkVehicleCommand;

class ParkVehicleHandler
{
    public function handle(ParkVehicleCommand $command): void
    {
        try {
            $command->getVehicle()->setLocation($command->getLocation());
        } catch (\Exception $e) {
            throw new \Exception('Could not park vehicle');
        }
    }
}
