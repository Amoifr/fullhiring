<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Infra\MessengerBus\QueryInterface;

class GetFleetByIdQuery implements QueryInterface
{
    private int $fleetId;

    public function __construct(int $fleetId)
    {
        $this->fleetId = $fleetId;
    }

    public function getFleetId(): int
    {
        return $this->fleetId;
    }
}
