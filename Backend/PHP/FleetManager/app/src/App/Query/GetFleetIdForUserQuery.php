<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Infra\MessengerBus\QueryInterface;

class GetFleetIdForUserQuery implements QueryInterface
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
