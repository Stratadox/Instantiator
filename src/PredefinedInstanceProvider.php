<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use function get_class;

/**
 * Provider for predefined instances.
 *
 * @author Stratadox
 */
final class PredefinedInstanceProvider implements Instantiator
{
    private $objects;
    private $offset;

    private function __construct(...$objects)
    {
        $this->objects = $objects;
        $this->offset = 0;
    }

    /**
     * Produces a new provider for predefined instances.
     *
     * @param mixed ...$objects           The objects to provide.
     * @return PredefinedInstanceProvider The object provider.
     */
    public static function use(...$objects): self
    {
        return new self(...$objects);
    }

    /** @inheritdoc */
    public function instance(): object
    {
        if (!isset($this->objects[$this->offset])) {
            throw NoMoreInstances::listRanOutAt($this->offset);
        }
        return $this->objects[$this->offset++];
    }

    /** @inheritdoc */
    public function class(): string
    {
        if (!isset($this->objects[$this->offset])) {
            return '';
        }
        return get_class($this->objects[$this->offset]);
    }
}
