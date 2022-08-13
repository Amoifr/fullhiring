<?php

declare(strict_types=1);

namespace Fulll\App\CommandHandler;

use Exception;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Infra\MessengerBus\CommandHandlerInterface;

class ParkVehicleHandler implements CommandHandlerInterface
{
    /**
     * @throws Exception
     */
    public function __invoke(ParkVehicleCommand $command): void
    {
        try {
            $command->getVehicle()->setLocation($command->getLocation());
        } catch (Exception $e) {
            throw new Exception('Could not park vehicle');
        }
    }
}
