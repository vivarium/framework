<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Hierarchy\IsAssignableToIntersection;
use Vivarium\Test\Assertion\Stub\InvokableStub;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

/** @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsAssignableToIntersection */
final class IsAssignableToIntersectionTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()'
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $intersection = Stub::class . '&' . InvokableStub::class;

        (new IsAssignableToIntersection($intersection))
            ->assert(StubClassExtension::class);
    }

    /**
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        $intersection = Stub::class . '&' . InvokableStub::class;

        static::assertTrue(
            (new IsAssignableToIntersection($intersection))(StubClassExtension::class)
        );

        static::assertFalse(
            (new IsAssignableToIntersection($intersection))(StubClass::class)
        );
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        $intersection = Stub::class . '&' . InvokableStub::class;

        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected class to be assignable to intersection "' . $intersection . '" Got "' . StubClass::class . '".',
        );

        (new IsAssignableToIntersection($intersection))
            ->assert(StubClass::class);
    }

    /**
     * @covers ::__construct()
     */
    public function testConstructorException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be intersection. Got "Foo|Bar".');

        (new IsAssignableToIntersection('Foo&Bar'))
            ->assert('stdClass');
    }
}
