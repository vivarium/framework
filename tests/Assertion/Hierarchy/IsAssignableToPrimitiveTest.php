<?php

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Hierarchy\IsAssignableToPrimitive;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

/**
 * @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsAssignableToPrimitive
 */
final class IsAssignableToPrimitiveTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     *
     * @dataProvider primitivePairs()
     */
    public function testAssert(string $primitive, string $type): void
    {
        static::expectNotToPerformAssertions();

        (new IsAssignableToPrimitive($primitive))
            ->assert($type);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected type to be assignable to primitive type "int". Got "float".'
        );

        (new IsAssignableToPrimitive('int'))
            ->assert('float');
    }

    /** @covers ::__construct() */
    public function testConstructorException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be a primitive type. Got "RandomString".');

        new IsAssignableToPrimitive('RandomString');
    }

    /** @return array<array<string>> */
    public function primitivePairs(): array
    {
        return [
            ['float', 'int'],
            ['string', 'string'],
            ['string', StubClass::class],
            ['object', StubClass::class],
            ['callable', StubClassExtension::class],
        ];
    }
}
