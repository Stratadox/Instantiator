<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use ReflectionException;
use function sprintf as withMessage;

/**
 * Notifies the client code that the class could not be found.
 *
 * @author Stratadox
 */
final class CannotFindTheClass extends InvalidArgumentException implements CannotInstantiateThis
{
    /**
     * Creates a new exception.
     *
     * @param ReflectionException $exception
     * @return CannotFindTheClass
     */
    public static function encountered(ReflectionException $exception): self
    {
        return new CannotFindTheClass(withMessage(
            'Could not create instantiator: %s.',
            $exception->getMessage()
        ));
    }
}
