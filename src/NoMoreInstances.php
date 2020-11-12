<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf;

/**
 * Notifies the client code that the object provider ran out of instances.
 *
 * @author Stratadox
 */
final class NoMoreInstances extends InvalidArgumentException implements InstantiationFailure
{
    /**
     * Creates a new exception.
     *
     * @return NoMoreInstances The exception to throw.
     */
    public static function listRanOutAt(int $offset): InstantiationFailure
    {
        return new self(sprintf(
            'There is no instance to provide at offset %d.',
            $offset
        ));
    }
}
