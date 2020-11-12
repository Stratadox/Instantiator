# Instantiator

[![Build Status](https://travis-ci.org/Stratadox/Instantiator.svg?branch=master)](https://travis-ci.org/Stratadox/Instantiator)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/Instantiator/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/Instantiator?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stratadox/Instantiator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Stratadox/Instantiator/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/stratadox/instantiator/v/stable)](https://packagist.org/packages/stratadox/instantiator)
[![License](https://poser.pugx.org/stratadox/instantiator/license)](https://packagist.org/packages/stratadox/instantiator)

Lightweight instantiator.

## Installation

Install using `composer require stratadox/instantiator`

## What is this?

The `Instantiator` module provides a most simplistic way of producing empty 
instances.

An [`Instantiator`](https://github.com/Stratadox/Instantiator/blob/master/contract/Instantiator.php), 
does so *for a specific class*.
In this way it differs from most other instantiator packages, which usually 
specify the class to instantiate as method parameter.

## Basic usage

```php
<?php
use Stratadox\Instantiator\ObjectInstantiator;

$provideFoo = ObjectInstantiator::forThe(Foo::class);

assert($provideFoo->instance() instanceof Foo);
assert(Foo::class === $provideFoo->class());
```

## How does it work?

The `ObjectInstantiator` class basically just extends `ReflectionClass` in order 
to alias its [`newInstanceWithoutConstructor`](http://php.net/manual/en/reflectionclass.newinstancewithoutconstructor.php)
method.
In cases where this instantiation method fails, for instance when a final class
inherits from an internal class, deserialization is used instead.

Alternatively, this module includes a `PredefinedInstanceProvider`. This one 
isn't really an instantiator, but rather an iterator, but that does not stop it 
from implementing the `Instantiator` interface.
