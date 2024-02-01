<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsNamespace;

use function sprintf;

/** @coversDefaultClass \Vivarium\Assertion\String\IsNamespace */
final class IsNamespaceTest extends TestCase
{
    /**
     * @covers ::assert()
     * @dataProvider namespaceProvider()
     */
    public function testAssert(string $namespace): void
    {
        static::expectNotToPerformAssertions();

        (new IsNamespace())
            ->assert($namespace);
    }

    /**
     * @covers ::assert()
     * @dataProvider wrongNamespaceProvider()
     */
    public function testAssertException(string $namespace): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            sprintf('Expected string to be namespace. Got "%s".', $namespace),
        );

        (new IsNamespace())
            ->assert($namespace);
    }

    /**
     * @covers ::__invoke()
     * @dataProvider namespaceProvider()
     */
    public function testInvoke(string $namespace): void
    {
        static::assertTrue(
            (new IsNamespace())($namespace),
        );
    }

    /**
     * @covers ::__invoke()
     * @dataProvider wrongNamespaceProvider()
     */
    public function testInvokeFail(string $namespace): void
    {
        static::assertFalse(
            (new IsNamespace())($namespace),
        );
    }

    /** @return array<array<string>> */
    public static function namespaceProvider(): array
    {
        return [
            ['Foo\\Bar'],
            ['Foo'],
            ['Foo\\Bar\\Baz'],
        ];
    }

    /** @return array<array<string>> */
    public static function wrongNamespaceProvider(): array
    {
        return [
            ["Foo\\12"],
            ['Foo\\Bar\\'],
        ];
    }
}
