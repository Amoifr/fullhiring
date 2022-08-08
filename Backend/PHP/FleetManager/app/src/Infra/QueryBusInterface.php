<?php

declare(strict_types=1);

namespace Fulll\Infra;

interface QueryBusInterface
{
    function ask(QueryInterface $query): mixed;
}