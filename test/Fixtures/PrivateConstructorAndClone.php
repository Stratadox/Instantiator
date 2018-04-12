<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test\Fixtures;

final class PrivateConstructorAndClone
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
