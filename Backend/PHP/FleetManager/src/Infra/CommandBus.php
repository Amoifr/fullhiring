<?php

namespace Fulll\Infra;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\App\CommandHandler\ParkVehicleHandler;
use Fulll\App\CommandHandler\RegisterVehicleIntoFleetHandler;
use Fulll\App\CommandInterface;
use Fulll\App\Query\GetFleetVehiclesQuery;
use Fulll\App\Query\GetVehicleLocationQuery;
use Fulll\App\QueryHandler\GetFleetVehiclesHandler;
use Fulll\App\QueryHandler\GetVehicleLocationHandler;
use League\Tactician\CommandBus as TacticianCommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

class CommandBus
{
    private array $handlers = [];

    public function __construct()  {
        $this->addHandler(new ParkVehicleHandler(), ParkVehicleCommand::class);
        $this->addHandler(new RegisterVehicleIntoFleetHandler(), RegisterVehicleIntoFleetCommand::class);
        $this->addHandler(new GetVehicleLocationHandler(), GetVehicleLocationQuery::class);
        $this->addHandler(new GetFleetVehiclesHandler(), GetFleetVehiclesQuery::class);
    }

    public function handle(CommandInterface $command)
    {
        return $this->handlers[get_class($command)]->handle($command);
    }

    private function addHandler($handler, string $commandClass): void
    {
        $this->handlers[$commandClass] = $handler;
    }
}
