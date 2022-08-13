<?php

namespace Fulll\Command;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Query\GetFleetIdForUserQuery;
use Fulll\Infra\MessengerBus\MessengerCommandBus;
use Fulll\Infra\MessengerBus\MessengerQueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFleetForUserCommand extends Command
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
        $this->setName('fulll:fleet:create')
            ->setDescription('create a fleet for a user')
            ->addArgument('userId', InputOption::VALUE_REQUIRED, 'id of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $time = time();
        $this->createFleet($input->getArgument('userId'));
        $output->writeLn(['', 'Output generated in '.(time() - $time).'s.']);

        return 0;
    }

    private function createFleet(int $userId): void
    {
        $this->commandBus->dispatch(new CreateFleetCommand($userId));
        $this->output->writeLn(['', 'Creating fleet for user '.$userId]);
        $fleetId = $this->queryBus->ask(new GetFleetIdForUserQuery($userId));
        $this->output->writeLn(['', 'Fleet created with id '.$fleetId]);
    }
}
