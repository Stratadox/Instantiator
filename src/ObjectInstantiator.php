<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use ReflectionClass;
use ReflectionException;
use function sprintf;
use function strlen;
use Throwable;

/**
 * Simple Instantiator.
 *
 * @author Stratadox
 */
final class ObjectInstantiator extends ReflectionClass implements Instantiator
{
    /** @throws InstantiationFailure */
    private function __construct(string $class)
    {
        try {
            parent::__construct($class);
        } catch (ReflectionException $exception) {
            throw NoSuchClass::encountered($exception);
        }
        if ($this->isAbstract()) {
            throw NoConcreteClass::cannotInstantiate($class);
        }
        if ($this->isInterface()) {
            throw NotAClass::cannotInstantiate($class);
        }
    }

    /**
     * Produces a new instantiator.
     *
     * @param string $class      The class to create the instantiator for.
     * @return Instantiator The instantiator for the class.
     * @throws InstantiationFailure
     */
    public static function forThe(string $class): Instantiator
    {
        return new ObjectInstantiator($class);
    }

    /** @inheritdoc */
    public function instance(): object
    {
        try {
            return $this->newInstanceWithoutConstructor();
        } catch (Throwable $exception) {
            return $this->newInstanceFromDeserialization();
        }
    }

    /** @inheritdoc */
    public function class(): string
    {
        return $this->getName();
    }

    private function newInstanceFromDeserialization(): object
    {
        $class = $this->getName();
        return unserialize(sprintf(
            'O:%d:"%s":0:{}',
            strlen($class),
            $class
        ), ['allowed_classes' => [$class]]);
    }
}
