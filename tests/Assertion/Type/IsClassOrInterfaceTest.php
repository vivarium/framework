<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsClassOrInterface;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsClassOrInterface */
final class IsClassOrInterfaceTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__construct()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsClassOrInterface())
            ->assert($type);
    }

    /** 
     * @covers ::assert()
     * @covers ::__construct()
     *
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(string|int $type, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsClassOrInterface())
            ->assert($type);
    }

    /**
     * @covers ::__invoke()
     * @covers ::__construct()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $type): void
    {
        static::assertTrue(
            (new IsClassOrInterface())($type),
        );
    }

    /**
     * @covers ::__invoke()
     * @covers ::__construct()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string $type): void
    {
        static::assertFalse(
            (new IsClassOrInterface())($type)
        );
    }

    /** @return array<array<string>> */
    public static function provideSuccess(): array
    {
        return [
            ['stdClass'],
            [Stub::class],
            [StubClass::class],
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [
                'NonExistentClass', 
                'Expected string to be class or interface name. Got "NonExistentClass".'
            ],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [42, 'Expected string to be class or interface name. Got 42']
        ];
    }
}
