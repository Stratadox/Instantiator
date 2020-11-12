<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use ReflectionException;
use function sprintf;

/**
 * Notifies the client code that the class could not be found.
 *
 * @author Stratadox
 */
final class NoSuchClass extends InvalidArgumentException implements InstantiationFailure
{
    /**
     * Creates a new exception.
     *
     * @param ReflectionException $exception The exception that was encountered.
     * @return InstantiationFailure          The new exception to throw.
     */
    public static function encountered(ReflectionException $exception): InstantiationFailure
    {
        return new self(sprintf(
            'Could not create instantiator: %s.',
            $exception->getMessage()
        ), 0, $exception);
    }
}
