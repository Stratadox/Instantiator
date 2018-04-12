<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

final class ThatIsAnInterface extends InvalidArgumentException implements CannotInstantiateThis
{
    public static function cannotInstantiate(string $class): self
    {
        return new ThatIsAnInterface(withMessage(
            'Could not create instantiator: %s is an interface.',
            $class
        ));
    }
}
