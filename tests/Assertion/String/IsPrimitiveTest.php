<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsPrimitive;

/** @covers \Vivarium\Assertion\String\IsPrimitive */
final class IsPrimitiveTest extends TestCase
{
    /**
     * @covers ::assert()
     * @dataProvider typesProvider()
     */
    public function testAssert(string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsPrimitive())
            ->assert($type);
    }

    /** @covers ::assert() */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be a primitive type. Got "RandomString".');

        (new IsPrimitive())
            ->assert('RandomString');
    }

    /**
     * @covers ::__invoke()
     * @dataProvider typesProvider()
     */
    public function testInvoke(string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsPrimitive())($type);
    }

    /** @return array<array<string>> */
    public function typesProvider(): array
    {
        return [
            ['int'],
            ['float'],
            ['string'],
            ['callable'],
            ['object'],
            ['array'],
        ];
    }
}
