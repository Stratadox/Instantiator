<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use InvalidArgumentException;
use function sprintf as withMessage;

final class ClassIsAbstract extends InvalidArgumentException implements CannotInstantiateThis
{
    public static function cannotInstantiate(string $class): self
    {
        return new ClassIsAbstract(withMessage(
            'Could not create instantiator: Class %s is abstract.',
            $class
        ));
    }
}
