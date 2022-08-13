<?php

namespace Fulll\Command;

use Fulll\App\Command\RegisterVehicleIntoFleetCommand;
use Fulll\App\Query\GetFleetByIdQuery;
use Fulll\App\Query\GetVehicleByPlateNumberQuery;
use Fulll\Infra\MessengerBus\MessengerCommandBus;
use Fulll\Infra\MessengerBus\MessengerQueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterVehicleInFleetCommand extends Command
{
    protected OutputInterface $output;
    private MessengerCommandBus $commandBus;
    private MessengerQueryBus $queryBus;

    public function __construct(
        MessengerCommandBus $commandBus,
        MessengerQueryBus $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('fulll:vehicle:register')
            ->setDescription('register vehicle in a fleet')
            ->addArgument('fleetId', InputOption::VALUE_REQUIRED, 'id of the fleet')
            ->addArgument('plateNumber', InputOption::VALUE_REQUIRED, 'vehicle plate number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $time = time();
        $this->assignFleetToVehicle($input->getArgument('fleetId'), $input->getArgument('plateNumber'));
        $output->writeLn(['', 'Output generated in '.(time() - $time).'s.']);

        return 0;
    }

    private function assignFleetToVehicle(int $fleetId, string $plateNumber): void
    {
        $vehicle = $this->queryBus->ask(new GetVehicleByPlateNumberQuery($plateNumber));
        $this->output->writeLn(['', 'Vehicle id is '.$vehicle->getId()]);
        $fleet = $this->queryBus->ask(new GetFleetByIdQuery($fleetId));

        $this->commandBus->dispatch(new RegisterVehicleIntoFleetCommand($fleet, $vehicle));
        $this->output->writeLn(['', 'Vehicle added into fleet '.$fleetId]);
    }
}
