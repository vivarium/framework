<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsIntersection;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsIntersection */
final class IsIntersectionTest extends TestCase
{
    /** @covers ::assert() */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsIntersection())
            ->assert('stdClass&Vivarium\Test\Assertion\Stub\StubClass');
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be intersection. Got "Foo&Bar".');

        (new IsIntersection())
            ->assert('Foo&Bar');
    }

    /** @covers ::assert() */
    public function testAssertExceptionSingleString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be intersection. Got "stdClass".');

        (new IsIntersection())
            ->assert('stdClass');
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithPrimitive(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be intersection. Got "int&float"');

        (new IsIntersection())
            ->assert('int&float');
    }

    /** @covers ::assert() */
    public function testAssertWithNonString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new IsIntersection())
            ->assert(1);
    }

    /** @covers ::__invoke() */
    public function testInvoke(): void
    {
        static::assertTrue(
            (new IsIntersection())('stdClass&Vivarium\Test\Assertion\Stub\StubClass'),
        );

        static::assertFalse(
            (new IsIntersection())('Foo&Bar'),
        );

        static::assertFalse(
            (new IsIntersection())('stdClass'),
        );
    }
}
