<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

/**
 * Notifies the client code that the class cannot be instantiated because it is
 * an interface.
 *
 * @author Stratadox
 */
final class ThatIsAnInterface extends InvalidArgumentException implements CannotInstantiateThis
{
    /**
     * Creates a new exception.
     *
     * @param string $class      The class that turns out to be an interface.
     * @return ThatIsAnInterface The exception to throw.
     */
    public static function cannotInstantiate(string $class): self
    {
        return new ThatIsAnInterface(withMessage(
            'Could not create instantiator: %s is an interface.',
            $class
        ));
    }
}
