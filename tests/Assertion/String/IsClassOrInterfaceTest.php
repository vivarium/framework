<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsClassOrInterface;
use Vivarium\Test\Assertion\Stub\Stub;

/** @coversDefaultClass \Vivarium\Assertion\String\IsClassOrInterface */
final class IsClassOrInterfaceTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsClassOrInterface())
            ->assert('stdClass');

        (new IsClassOrInterface())
            ->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        static::assertTrue(
            (new IsClassOrInterface())('stdClass'),
        );

        static::assertTrue(
            (new IsClassOrInterface())(Stub::class),
        );

        static::assertFalse(
            (new IsClassOrInterface())('NonExistentClass'),
        );
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be class or interface name. Got "Foo".');

        (new IsClassOrInterface())
            ->assert('Foo');
    }

    /** @covers ::assert() */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new IsClassOrInterface())
            ->assert(42);
    }
}
