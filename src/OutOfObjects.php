<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

final class OutOfObjects extends InvalidArgumentException implements CannotInstantiateThis
{
    public static function alreadyUsedAllOfThem(): self
    {
        return new OutOfObjects('Out of objects!');
    }
}
