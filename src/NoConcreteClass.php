<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf;

/**
 * Notifies the client code that the class cannot be instantiated because it is
 * abstract.
 *
 * @author Stratadox
 */
final class NoConcreteClass extends InvalidArgumentException implements InstantiationFailure
{
    /**
     * Creates a new exception.
     *
     * @param string $class    The class that turns out to be abstract.
     * @return NoConcreteClass The exception to throw.
     */
    public static function cannotInstantiate(string $class): InstantiationFailure
    {
        return new self(sprintf(
            'Could not create instantiator: Class %s is abstract.',
            $class
        ));
    }
}
