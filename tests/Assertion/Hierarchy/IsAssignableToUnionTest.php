<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Hierarchy\IsAssignableToUnion;
use Vivarium\Test\Assertion\Stub\StubClass;

/** @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsAssignableToUnion */
final class IsAssignableToUnionTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $union = 'stdClass|' . StubClass::class;

        $assertion = new IsAssignableToUnion($union);
        $assertion->assert('stdClass');
        $assertion->assert(StubClass::class);
    }

    /** @covers ::__invoke() */
    public function testInvoke(): void
    {
        $union = 'stdClass|' . StubClass::class;

        $assertion = new IsAssignableToUnion($union);

        static::assertTrue($assertion('stdClass'));
        static::assertTrue($assertion(StubClass::class));
        static::assertFalse($assertion('int'));
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected type to be assignable to union "int|float" Got "stdClass".');

        (new IsAssignableToUnion('int|float'))
            ->assert('stdClass');
    }

    /** @covers ::__construct() */
    public function testConstructorException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be union. Got "Foo&Bar".');

        (new IsAssignableToUnion('Foo&Bar'))
            ->assert('stdClass');
    }
}
