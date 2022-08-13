<?php

declare(strict_types=1);

namespace Fulll\Infra\MessengerBus;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
