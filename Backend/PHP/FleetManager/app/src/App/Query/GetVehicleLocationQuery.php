<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\QueryInterface;

class GetVehicleLocationQuery implements QueryInterface
{
    private Vehicle $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
}
