<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Object;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Object\HasMethod;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;

/** @coversDefaultClass \Vivarium\Assertion\Object\HasMethod */
final class HasMethodTest extends TestCase
{
    /** @covers ::assert() */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $assertion = new HasMethod('__toString');

        $assertion->assert(Stub::class);
        $assertion->assert(new StubClass());
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected "stdClass" to have a method named "__toString".');

        (new HasMethod('__toString'))
            ->assert(stdClass::class);
    }

    /** @covers ::__invoke() */
    public function testInvoke(): void
    {
        $assertion = new HasMethod('__toString');

        static::assertTrue($assertion(StubClass::class));
        static::assertTrue($assertion(new StubClass()));
        static::assertFalse($assertion(stdClass::class));
    }

    /** @covers ::__invoke() */
    public function testInvokeException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Value must be either class, interface or object. Got "RandomString"');

        (new HasMethod('__toString'))('RandomString');
    }
}
