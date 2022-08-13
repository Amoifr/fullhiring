<?php

declare(strict_types=1);

namespace Fulll\Infra\MessengerBus;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
