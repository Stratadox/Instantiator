<?php
declare(strict_types=1);

namespace Stratadox\Instantiator\Test;

use function array_merge;
use function assert;
use Exception;
use InvalidArgumentException;
use function is_string;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;
use Stratadox\Instantiator\CannotFindTheClass;
use Stratadox\Instantiator\CannotInstantiateThis;
use Stratadox\Instantiator\ClassIsAbstract;
use Stratadox\Instantiator\Instantiator;
use Stratadox\Instantiator\Test\Fixtures\AbstractClass;
use Stratadox\Instantiator\Test\Fixtures\AnInterface;
use Stratadox\Instantiator\Test\Fixtures\ExceptionThrowingConstructor;
use Stratadox\Instantiator\Test\Fixtures\PrivateClone;
use Stratadox\Instantiator\Test\Fixtures\PrivateConstructor;
use Stratadox\Instantiator\Test\Fixtures\PrivateConstructorAndClone;
use Stratadox\Instantiator\ThatIsAnInterface;

/**
 * @covers \Stratadox\Instantiator\Instantiator
 * @covers \Stratadox\Instantiator\CannotFindTheClass
 * @covers \Stratadox\Instantiator\ClassIsAbstract
 * @covers \Stratadox\Instantiator\ThatIsAnInterface
 */
class Instantiator_creates_empty_instances extends TestCase
{
    /**
     * @test
     * @dataProvider classes
     */
    function creating_instances_without_calling_the_constructor(string $class)
    {
        $instance = Instantiator::forThe($class)->instance();

        $this->assertInstanceOf($class, $instance);
    }

    /**
     * @test
     * @dataProvider classes
     */
    function creating_a_new_instance_on_each_call(string $class)
    {
        $instantiator = Instantiator::forThe($class);

        $instance1 = $instantiator->instance();
        $instance2 = $instantiator->instance();

        $this->assertEquals($instance1, $instance2);
        $this->assertNotSame($instance1, $instance2);
    }

    /**
     * @test
     * @dataProvider classes
     */
    function finding_out_which_class_is_instantiated(string $class)
    {
        $this->assertEquals($class, Instantiator::forThe($class)->class());
    }

    /**
     * @test
     * @dataProvider illegalClasses
     */
    function throwing_an_invalid_argument_exception_when_the_class_does_not_exist(
        string $class,
        string $expectedClass,
        string $expectedMessage
    ) {
        $this->expectException($expectedClass);
        $this->expectExceptionMessage($expectedMessage);

        Instantiator::forThe($class);
    }

    /**
     * @test
     * @dataProvider allClasses
     */
    function either_throwing_an_exception_in_the_constructor_or_correctly_instantiating(
        string $class,
        string $expectedClass = 'N/A',
        string $expectedMessage = 'N/A'
    ) {
        try {
            $instantiator = Instantiator::forThe($class);
        } catch (CannotInstantiateThis $exception) {
            $this->assertInstanceOf($expectedClass, $exception);
            $this->assertEquals($expectedMessage, $exception->getMessage());
            return;
        }
        $instance = $instantiator->instance();
        $this->assertInstanceOf($class, $instance);
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
        ];
    }

    public function illegalClasses(): array
    {
        return [
            'non existing class' => [
                'non existing class',
                CannotFindTheClass::class,
                'Could not create instantiator: Class non existing class does not exist.'
            ],
            'abstract class' => [
                AbstractClass::class,
                ClassIsAbstract::class,
                'Could not create instantiator: Class '.AbstractClass::class.' is abstract.'
            ],
            'interface' => [
                AnInterface::class,
                ThatIsAnInterface::class,
                'Could not create instantiator: '.AnInterface::class.' is an interface.'
            ],
        ];
    }

    public function allClasses(): array
    {
        return array_merge($this->classes(), $this->illegalClasses());
    }
}
