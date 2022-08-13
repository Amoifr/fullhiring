<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Domain\Entity\Fleet;
use Fulll\Infra\MessengerBus\QueryInterface;

class GetFleetVehiclesQuery implements QueryInterface
{
    private Fleet $fleet;

    public function __construct(Fleet $fleet)
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }
}
