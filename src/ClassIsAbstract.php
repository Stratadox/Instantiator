<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

/**
 * Notifies the client code that the class cannot be instantiated because it is
 * abstract.
 *
 * @author Stratadox
 */
final class ClassIsAbstract extends InvalidArgumentException implements CannotInstantiateThis
{
    /**
     * Creates a new exception.
     *
     * @param string $class    The class that turns out to be abstract.
     * @return ClassIsAbstract The exception to throw.
     */
    public static function cannotInstantiate(string $class): self
    {
        return new ClassIsAbstract(withMessage(
            'Could not create instantiator: Class %s is abstract.',
            $class
        ));
    }
}
