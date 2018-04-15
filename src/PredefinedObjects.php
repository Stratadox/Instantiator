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
        if (!isset($this->objects[$this->current])) {
            throw OutOfObjects::alreadyUsedAllOfThem();
        }
        $object = $this->objects[$this->current];
        ++$this->current;
        return $object;
    }

    public function class(): string
    {
        return get_class($this->objects[$this->current]);
    }
}
