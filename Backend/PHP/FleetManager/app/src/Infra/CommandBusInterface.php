<?php

declare(strict_types=1);

namespace Fulll\Infra;

interface CommandBusInterface
{
    function dispatch(CommandInterface $command): void;
}