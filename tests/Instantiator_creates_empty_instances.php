<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test;

use function array_merge;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;
use Stratadox\Instantiator\NoSuchClass;
use Stratadox\Instantiator\InstantiationFailure;
use Stratadox\Instantiator\NoConcreteClass;
use Stratadox\Instantiator\ObjectInstantiator;
use Stratadox\Instantiator\Test\Fixtures\AbstractClass;
use Stratadox\Instantiator\Test\Fixtures\AnInterface;
use Stratadox\Instantiator\Test\Fixtures\ExceptionThrowingConstructor;
use Stratadox\Instantiator\Test\Fixtures\FinalInternal;
use Stratadox\Instantiator\Test\Fixtures\PrivateClone;
use Stratadox\Instantiator\Test\Fixtures\PrivateConstructor;
use Stratadox\Instantiator\Test\Fixtures\PrivateConstructorAndClone;
use Stratadox\Instantiator\NotAClass;

class Instantiator_creates_empty_instances extends TestCase
{
    /**
     * @test
     * @dataProvider classes
     */
    function creating_instances_without_calling_the_constructor(string $class)
    {
        $instance = ObjectInstantiator::forThe($class)->instance();

        self::assertInstanceOf($class, $instance);
    }

    /**
     * @test
     * @dataProvider classes
     */
    function creating_a_new_instance_on_each_call(string $class)
    {
        $instantiator = ObjectInstantiator::forThe($class);

        $instance1 = $instantiator->instance();
        $instance2 = $instantiator->instance();

        self::assertEquals($instance1, $instance2);
        self::assertNotSame($instance1, $instance2);
    }

    /**
     * @test
     * @dataProvider classes
     */
    function finding_out_which_class_is_instantiated(string $class)
    {
        self::assertEquals($class, ObjectInstantiator::forThe($class)->class());
    }

    /**
     * @test
     * @dataProvider illegalClasses
     */
    function throwing_an_invalid_argument_exception_when_the_class_does_not_exist(
        string $class,
        string $expectedClass
    ) {
        $this->expectException($expectedClass);

        ObjectInstantiator::forThe($class);
    }

    /**
     * @test
     * @dataProvider allClasses
     */
    function either_throwing_an_exception_in_the_constructor_or_correctly_instantiating(
        string $class,
        string $expectedClass = 'N/A'
    ) {
        try {
            $instantiator = ObjectInstantiator::forThe($class);
        } catch (InstantiationFailure $exception) {
            self::assertInstanceOf($expectedClass, $exception);
            return;
        }
        $instance = $instantiator->instance();
        self::assertInstanceOf($class, $instance);
    }

    public function classes(): array
    {
        return [
            'class with exception in the constructor'  => [ExceptionThrowingConstructor::class],
            'class with private clone'                 => [PrivateClone::class],
            'class with private constructor'           => [PrivateConstructor::class],
            'class with private constructor and clone' => [PrivateConstructorAndClone::class],
            'this test class'                          => [__CLASS__],
            'the basic Exception class'                => [Exception::class],
            'an InvalidArgumentException'              => [InvalidArgumentException::class],
            'the built-in stdClass'                    => [stdClass::class],
            'a ReflectionClass'                        => [ReflectionClass::class],
            'a final internal class'                   => [FinalInternal::class],
        ];
    }

    public function illegalClasses(): array
    {
        return [
            'non existing class' => [
                'non existing class',
                NoSuchClass::class
            ],
            'abstract class' => [
                AbstractClass::class,
                NoConcreteClass::class
            ],
            'interface' => [
                AnInterface::class,
                NotAClass::class
            ],
        ];
    }

    public function allClasses(): array
    {
        return array_merge($this->classes(), $this->illegalClasses());
    }
}
