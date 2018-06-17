<?php

namespace Stratadox\Instantiator;

/**
 * Produces instances of a class.
 *
 * @author Stratadox
 */
interface ProvidesInstances
{
    /**
     * Makes a new instance of the class, without calling the constructor.
     *
     * @return object A new instance of the class.
     */
    public function instance(): object;

    /**
     * Informs about the class of the instances that are produced.
     *
     * @return string The fully qualified name of the class.
     */
    public function class(): string;
}
