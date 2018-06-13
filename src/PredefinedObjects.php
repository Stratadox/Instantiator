<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use function get_class;

/**
 * Provider for predefined instances.
 *
 * @author Stratadox
 */
final class PredefinedObjects implements ProvidesInstances
{
    private $objects;
    private $current;

    private function __construct(...$objects)
    {
        $this->objects = $objects;
        $this->current = 0;
    }

    /**
     * Produces a new provider for predefined instances.
     *
     * @param mixed ...$objects  The objects to provide.
     * @return PredefinedObjects The object provider.
     */
    public static function use(...$objects): self
    {
        return new self(...$objects);
    }

    /** @inheritdoc */
    public function instance(): object
    {
        if (!isset($this->objects[$this->current])) {
            throw OutOfObjects::alreadyUsedAllOfThem();
        }
        $object = $this->objects[$this->current];
        ++$this->current;
        return $object;
    }

    /** @inheritdoc */
    public function class(): string
    {
        if (!isset($this->objects[$this->current])) {
            return '';
        }
        return get_class($this->objects[$this->current]);
    }
}
