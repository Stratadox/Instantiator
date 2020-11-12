<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf;

/**
 * Notifies the client code that the class cannot be instantiated because it is
 * an interface.
 *
 * @author Stratadox
 */
final class NotAClass extends InvalidArgumentException implements InstantiationFailure
{
    /**
     * Creates a new exception.
     *
     * @param string $class         The class that turns out to be an interface.
     * @return InstantiationFailure The exception to throw.
     */
    public static function cannotInstantiate(string $class): InstantiationFailure
    {
        return new self(sprintf(
            'Could not create instantiator: %s is an interface.',
            $class
        ));
    }
}
