<?php

declare(strict_types=1);

namespace Fulll\App\CommandHandler;

use Exception;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Repository\FleetRepository;
use Fulll\App\Repository\UserRepository;
use Fulll\Domain\Entity\Fleet;
use Fulll\Infra\MessengerBus\CommandHandlerInterface;

class CreateFleetHandler implements CommandHandlerInterface
{
    private UserRepository $userRepository;
    private FleetRepository $fleetRepository;

    public function __construct(
        UserRepository $userRepository,
        FleetRepository $fleetRepository
    ) {
        $this->userRepository = $userRepository;
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateFleetCommand $command): void
    {
        try {
            $user = $this->userRepository->find($command->getUserId());
            if (null === $user) {
                throw new Exception('User not found');
            }
            if (null !== $user->getFleet()) {
                throw new Exception('User already has a fleet');
            }
            $fleet = new Fleet();
            $user->setFleet($fleet);
            $fleet->setUser($user);
            $this->userRepository->save($user);
            $this->fleetRepository->save($fleet);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
