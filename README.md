# Instantiator

Lightweight instantiator.

## Installation

Install using `composer require stratadox/instantiator`

## What is this?

The `Instantiator` module provides a most simplistic way of producing empty 
instances.

An object that [`ProvidesInstances`](https://github.com/Stratadox/Instantiator/blob/master/contract/ProvidesInstances.php), 
generally does so *for a specific class*.

In this way it differs from most other instantiator packages, which usually 
specify the class to instantiate as method parameter.

## How does it work?

The `Instantiator` class basically just extends `ReflectionClass` in order to
alias its [`newInstanceWithoutConstructor`](http://php.net/manual/en/reflectionclass.newinstancewithoutconstructor.php)
method. It's basically an adapter for the `ProvidesInstances` interface that's
implemented through inheritance.

Alternatively, this module provides a container for `PredefinedObjects`. This
one isn't really an instantiator, but rather an iterator, but that does not stop
it from implementing the `ProvidesInstances` interface.
