<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use ReflectionClass;
use ReflectionException;

/**
 * Simple Instantiator.
 *
 * @author Stratadox
 */
final class Instantiator extends ReflectionClass implements ProvidesInstances
{
    /** @throws CannotInstantiateThis */
    public function __construct(string $class)
    {
        try {
            parent::__construct($class);
        } catch (ReflectionException $exception) {
            throw CannotFindTheClass::encountered($exception);
        }
        if ($this->isAbstract()) {
            throw ClassIsAbstract::cannotInstantiate($class);
        }
        if ($this->isInterface()) {
            throw ThatIsAnInterface::cannotInstantiate($class);
        }
    }

    /**
     * Produces a new instantiator.
     *
     * @param string $class The class to create the instantiator for.
     * @return Instantiator The instantiator for the class.
     * @throws CannotInstantiateThis
     */
    public static function forThe(string $class): self
    {
        return new Instantiator($class);
    }

    /** @inheritdoc */
    public function instance()
    {
        return $this->newInstanceWithoutConstructor();
    }

    /** @inheritdoc */
    public function class(): string
    {
        return $this->getName();
    }
}
