<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsType;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsType */
final class IsTypeTest extends TestCase
{
    /**
     * @covers ::assert()
     * @dataProvider provideTypes()
     */
    public function testAssert(string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsType())
            ->assert($type);
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected string to be a primitive, class, interface, union or intersection. Got "NonExistentClass".',
        );

        (new IsType())
            ->assert('NonExistentClass');
    }

    /** @covers ::assert() */
    public function testAssertWithNonString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected string to be a primitive, class, interface, union or intersection. Got 1.',
        );

        (new IsType())
            ->assert(1);
    }

    /**
     * @covers ::__invoke()
     * @dataProvider provideTypes()
     */
    public function testInvoke(string $type): void
    {
        static::assertTrue(
            (new IsType())($type),
        );
    }

    /** @return array<array<string>> */
    public static function provideTypes(): array
    {
        return [
            ['int'],
            ['float'],
            ['string'],
            ['callable'],
            ['object'],
            ['array'],
            ['stdClass'],
            ['Vivarium\Test\Assertion\Stub\StubClass'],
            ['stdClass|Vivarium\Test\Assertion\Stub\StubClass'],
            ['stdClass&Vivarium\Test\Assertion\Stub\StubClass'],
        ];
    }
}
