<?php

declare(strict_types=1);

namespace Fulll\App\QueryHandler;

use Exception;
use Fulll\App\Query\GetFleetIdForUserQuery;
use Fulll\App\Repository\UserRepository;
use Fulll\Infra\MessengerBus\QueryHandlerInterface;

class GetFleetIdForUserHandler implements QueryHandlerInterface
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetFleetIdForUserQuery $query): int
    {
        $user = $this->userRepository->find($query->getUserId());
        if (null === $user) {
            throw new Exception('User not found');
        }

        return $user->getFleet()->getId();
    }
}
