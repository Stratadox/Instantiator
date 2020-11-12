<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Instantiator\InstantiationFailure;
use Stratadox\Instantiator\PredefinedInstanceProvider;
use Stratadox\Instantiator\Test\Fixtures\Bar;
use Stratadox\Instantiator\Test\Fixtures\Foo;

class PredefinedObjects_iterates_over_a_list_of_instances extends TestCase
{
    /** @test */
    function retrieving_the_objects_one_by_one()
    {
        $foo1 = new Foo;
        $foo2 = new Foo;
        $instances = PredefinedInstanceProvider::use($foo1, $foo2);

        self::assertSame($foo1, $instances->instance());
        self::assertSame($foo2, $instances->instance());
    }

    /** @test */
    function retrieving_the_class_of_the_next_instance()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedInstanceProvider::use($foo, $bar);

        self::assertSame(Foo::class, $instances->class());
        self::assertInstanceOf(Foo::class, $instances->instance());

        self::assertSame(Bar::class, $instances->class());
        self::assertInstanceOf(Bar::class, $instances->instance());
    }

    /** @test */
    function throwing_an_exception_when_out_of_objects()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedInstanceProvider::use($foo, $bar);

        $instances->instance();
        $instances->instance();

        $this->expectException(InstantiationFailure::class);

        $instances->instance();
    }

    /** @test */
    function returning_an_empty_string_when_asked_for_the_class_while_out_of_objects()
    {
        $foo = new Foo;
        $bar = new Bar;

        $instances = PredefinedInstanceProvider::use($foo, $bar);

        $instances->instance();
        $instances->instance();

        self::assertSame('', $instances->class());
    }
}
