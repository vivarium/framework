<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsBasicType;

/** @coversDefaultClass \Vivarium\Assertion\String\IsBasicType */
final class IsBasicTypeTest extends TestCase
{
    /**
     * @covers ::assert()
     * @dataProvider provideTypes()
     */
    public function testAssert(string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsBasicType())
            ->assert($type);
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected string to be a primitive type, class or interface. Got "stdClass|StubClass".',
        );

        (new IsBasicType())
            ->assert('stdClass|StubClass');
    }

    /** @covers ::assert() */
    public function testAssertExceptionWithNonString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be a primitive type, class or interface. Got 1.');

        (new IsBasicType())
            ->assert(1);
    }

    /**
     * @covers ::__invoke()
     * @dataProvider provideTypes()
     */
    public function testInvoke(string $type): void
    {
        static::assertTrue(
            (new IsBasicType())($type),
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
        ];
    }
}
