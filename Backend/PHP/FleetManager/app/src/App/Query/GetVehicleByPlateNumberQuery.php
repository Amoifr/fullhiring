<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Infra\MessengerBus\QueryInterface;

class GetVehicleByPlateNumberQuery implements QueryInterface
{
    private string $plateNumber;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
