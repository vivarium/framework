<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Test\Assertion\Stub\InvokableStub;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

use function sprintf;

/** @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsAssignableTo */
final class IsAssignableToTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     * @covers ::getAssertion()
     * @dataProvider pairAssignmentProvider()
     */
    public function testAssert(string $type, string $assign): void
    {
        static::expectNotToPerformAssertions();

        (new IsAssignableTo($type))
            ->assert($assign);
    }

    /**
     * @covers ::__invoke()
     * @covers ::getAssertion()
     * @dataProvider pairAssignmentProvider()
     */
    public function testInvoke(string $type, string $assign): void
    {
        static::assertTrue((new IsAssignableTo($type))($assign));
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            sprintf(
                'Expected type "%s" to be assignable to "%2$s".',
                Stub::class,
                StubClassExtension::class,
            ),
        );

        (new IsAssignableTo(StubClassExtension::class))
            ->assert(Stub::class);
    }

    /** @covers ::__construct() */
    public function testConstructorWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected string to be a primitive, class, interface, union or intersection. Got "RandomString"',
        );

        /**
         * This is covered by static analysis, but it is a valid runtime call
         *
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         */
        (new IsAssignableTo('RandomString'))
            ->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            'Expected string to be a primitive, class, interface, union or intersection. Got "RandomString".',
        );

        (new IsAssignableTo(Stub::class))
            ->assert('RandomString');
    }

    /** @covers ::__invoke() */
    public function testInvokeFalsy(): void
    {
        static::assertFalse(
            (new IsAssignableTo(StubClassExtension::class))('string'),
        );
    }

    /** @return array<array<string>> */
    public function pairAssignmentProvider(): array
    {
        return [
            [Stub::class, Stub::class],
            [Stub::class, StubClass::class],
            [Stub::class, StubClassExtension::class],
            [StubClass::class, StubClassExtension::class],
            ['float', 'int'],
            ['string', 'string'],
            ['callable', InvokableStub::class],
            ['string', StubClass::class],
            ['stdClass|' . StubClass::class, 'stdClass'],
            ['stdClass|' . StubClass::class, StubClassExtension::class],
            [Stub::class . '&' . InvokableStub::class, StubClassExtension::class],
        ];
    }
}
