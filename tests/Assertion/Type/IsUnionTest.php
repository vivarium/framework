<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsUnion;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsUnion */
final class IsUnionTest extends TestCase
{
    /** @covers ::assert() */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsUnion())
            ->assert('stdClass|Vivarium\Test\Assertion\Stub\StubClass');
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be union. Got "Foo|Bar".');

        (new IsUnion())
            ->assert('Foo|Bar');
    }

    /** @covers ::assert() */
    public function testAssertExceptionSingleString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be union. Got "stdClass".');

        (new IsUnion())
            ->assert('stdClass');
    }

    /** @covers ::assert() */
    public function testAssertWithNonString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new IsUnion())
            ->assert(1);
    }

    /** @covers ::__invoke() */
    public function testInvoke(): void
    {
        static::assertTrue(
            (new IsUnion())('stdClass|Vivarium\Test\Assertion\Stub\StubClass'),
        );

        static::assertFalse(
            (new IsUnion())('Foo|Bar'),
        );

        static::assertFalse(
            (new IsUnion())('stdClass'),
        );
    }
}
