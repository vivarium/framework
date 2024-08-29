<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsNamespace;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsNamespace */
final class IsNamespaceTest extends TestCase
{
    /**
     * @covers ::assert()
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $namespace): void
    {
        static::expectNotToPerformAssertions();

        (new IsNamespace())
            ->assert($namespace);
    }

    /**
     * @covers ::assert()
     * @dataProvider provideFailure()
     */
    public function testAssertException(string $namespace, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsNamespace())
            ->assert($namespace);
    }

    /**
     * @covers ::__invoke()
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $namespace): void
    {
        static::assertTrue(
            (new IsNamespace())($namespace),
        );
    }

    /**
     * @covers ::__invoke()
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string $namespace): void
    {
        static::assertFalse(
            (new IsNamespace())($namespace),
        );
    }

    /** @return array<array<string>> */
    public static function provideSuccess(): array
    {
        return [
            ['Foo\\Bar'],
            ['Foo'],
            ['Foo\\Bar\\Baz'],
        ];
    }

    /** @return array<array<string>> */
    public static function provideFailure(): array
    {
        return [
            [
                'Foo\\12',
                'Expected string to be namespace. Got "Foo\\12".',
            ],
        ];
    }
}
