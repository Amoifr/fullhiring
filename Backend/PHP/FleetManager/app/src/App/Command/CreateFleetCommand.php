<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Infra\MessengerBus\CommandInterface;

class CreateFleetCommand implements CommandInterface
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
