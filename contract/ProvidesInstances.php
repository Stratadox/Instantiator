<?php

namespace Stratadox\Instantiator;

/**
 * Produces instances of a class.
 *
 * Such instantiator is generally an instantiator *for a class*.
 *
 * @author Stratadox
 */
interface ProvidesInstances
{
    /**
     * Makes a new instance of the class, without calling the constructor.
     *
     * @return mixed|object The object that is instantiated.
     * @throws CannotInstantiateThis
     */
    public function instance();

    /**
     * Informs about the class of the instances that are produced.
     *
     * @return string The fully qualified name of the class.
     */
    public function class(): string;
}
