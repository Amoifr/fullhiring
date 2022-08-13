<?php

namespace Fulll\Command;

use Fulll\App\Query\GetVehicleByPlateNumberQuery;
use Fulll\Infra\MessengerBus\MessengerCommandBus;
use Fulll\Infra\MessengerBus\MessengerQueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LocalizeVehicleCommand extends Command
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

    protected function configure(): void
    {
        $this->setName('fulll:vehicle:localize')
            ->setDescription('localize vehicle with latitude and longitude')
            ->addArgument('fleetId', InputOption::VALUE_REQUIRED, 'fleet id')
            ->addArgument('plateNumber', InputOption::VALUE_REQUIRED, 'plate number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $time = time();
        $this->parkVehicle(
            $input->getArgument('plateNumber')
        );
        $output->writeLn(['', 'Output generated in '.(time() - $time).'s.']);

        return 0;
    }

    private function parkVehicle(
        string $plateNumber
    ): void {
        $vehicle = $this->queryBus->ask(new GetVehicleByPlateNumberQuery($plateNumber));
        $this->output->writeLn(['', 'Vehicle id is '.$vehicle->getId()]);

        $this->output->writeLn(['', 'Vehicle park in '.$vehicle->getLocation()->getLatitude().', '.$vehicle->getLocation()->getLongitude()]);
    }
}
