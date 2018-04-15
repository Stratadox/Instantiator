<?php
declare(strict_types=1);

namespace Stratadox\Instantiator;

use function get_class;

class PredefinedObjects implements ProvidesInstances
{
    private $objects;
    private $current;

    private function __construct(...$objects)
    {
        $this->objects = $objects;
        $this->current = 0;
    }

    public static function use(...$objects): self
    {
        return new self(...$objects);
    }

    public function instance()
    {
        $object = $this->currentObject();
        ++$this->current;
        return $object;
    }

    public function class(): string
    {
        return get_class($this->currentObject());
    }

    private function currentObject()
    {
        return $this->objects[$this->current];
    }
}
