<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test\Fixtures;

use BadMethodCallException;

final class ExceptionThrowingConstructor
{
    /** @throws */
    public function __construct()
    {
        throw new BadMethodCallException('Should not call the constructor.');
    }
}
