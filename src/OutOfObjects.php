<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

/**
 * Notifies the client code that the object provider ran out of instances.
 *
 * @author Stratadox
 */
final class OutOfObjects extends InvalidArgumentException implements CannotInstantiateThis
{
    /**
     * Creates a new exception.
     *
     * @return OutOfObjects The exception to throw.
     */
    public static function alreadyUsedAllOfThem(): self
    {
        return new OutOfObjects('Out of objects!');
    }
}
