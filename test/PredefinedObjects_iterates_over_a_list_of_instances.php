<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Instantiator\CannotInstantiateThis;
use Stratadox\Instantiator\PredefinedObjects;
use Stratadox\Instantiator\Test\Fixtures\Bar;
use Stratadox\Instantiator\Test\Fixtures\Foo;

/**
 * @covers \Stratadox\Instantiator\PredefinedObjects
 * @covers \Stratadox\Instantiator\OutOfObjects
 */
class PredefinedObjects_iterates_over_a_list_of_instances extends TestCase
{
    /** @test */
    function retrieving_the_objects_one_by_one()
    {
        $foo1 = new Foo;
        $foo2 = new Foo;
        $instances = PredefinedObjects::use($foo1, $foo2);

        $this->assertSame($foo1, $instances->instance());
        $this->assertSame($foo2, $instances->instance());
    }

    /** @test */
    function retrieving_the_class_of_the_next_instance()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedObjects::use($foo, $bar);

        $this->assertSame(Foo::class, $instances->class());
        $this->assertInstanceOf(Foo::class, $instances->instance());

        $this->assertSame(Bar::class, $instances->class());
        $this->assertInstanceOf(Bar::class, $instances->instance());
    }

    /** @test */
    function throwing_an_exception_when_out_of_objects()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedObjects::use($foo, $bar);

        $instances->instance();
        $instances->instance();

        $this->expectException(CannotInstantiateThis::class);
        $this->expectExceptionMessage(
            'Out of objects!'
        );

        $instances->instance();
    }

    /** @test */
    function returning_an_empty_string_when_asked_for_the_class_while_out_of_objects()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedObjects::use($foo, $bar);

        $instances->instance();
        $instances->instance();

        $this->assertSame('', $instances->class());
    }
}
