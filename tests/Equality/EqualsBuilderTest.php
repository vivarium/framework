<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Equality\Test;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Equality\Equality;
use Vivarium\Equality\EqualsBuilder;

/** @coversDefaultClass \Vivarium\Equality\EqualsBuilder */
final class EqualsBuilderTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::append
     * @covers ::isEquals
     * @dataProvider getTestAppendScalarData
     */
    public function testAppendScalar(mixed $first, mixed $second, bool $expected): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append($first, $second);

        static::assertEquals($expected, $builder->isEquals());
    }

    /**
     * @covers ::append
     * @covers ::isEquals
     */
    public function testAppendMultipleTimes(): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append('a', 'b');
        $builder = $builder->append(42, 42);

        static::assertEquals(false, $builder->isEquals());
    }

    /**
     * @param mixed[] $array1
     * @param mixed[] $array2
     *
     * @covers ::append
     * @covers ::appendEach
     * @covers ::isEquals
     * @covers ::reject
     * @dataProvider getTestAppendEachData
     */
    public function testAppendEach(array $array1, array $array2, bool $expected): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append($array1, $array2);

        static::assertEquals($expected, $builder->isEquals());
    }

    /**
     * @covers ::append
     * @covers ::appendObject
     * @covers ::isEquals
     * @dataProvider getTestAppendObjectData
     */
    public function testAppendObject(mixed $object1, mixed $object2, bool $expected): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append($object1, $object2);

        static::assertEquals($expected, $builder->isEquals());
    }

    /**
     * @covers ::append
     * @covers ::appendFloat
     * @covers ::isEquals
     * @dataProvider getTestAppendFloatData
     */
    public function testAppendFloat(float $first, float $second, bool $expected): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append($first, $second);

        static::assertEquals($expected, $builder->isEquals());
    }

    /**
     * @covers ::append()
     * @covers ::isEquals()
     * @dataProvider getTestAppendMixedData
     */
    public function testAppendDifferentTypes(mixed $first, mixed $second): void
    {
        $builder = new EqualsBuilder();
        $builder = $builder->append($first, $second);

        static::assertFalse($builder->isEquals());
    }

    /**
     * @covers ::append()
     * @dataProvider getClonePointData
     */
    public function testImmutability(mixed $first, mixed $second): void
    {
        $builder  = new EqualsBuilder();
        $builder1 = $builder->append($first, $second);

        static::assertNotSame($builder, $builder1);
    }

    /** @return array<array-key, array{0: scalar, 1: scalar, 2: bool}> */
    public static function getTestAppendScalarData(): array
    {
        return [
            'Integer Equality' =>
                [
                    42,
                    42,
                    true,
                ],
            'String Equality' =>
                [
                    'hello',
                    'hello',
                    true,
                ],
            'Boolean Equality' =>
                [
                    false,
                    false,
                    true,
                ],
            'Integer Inequality' =>
                [
                    1,
                    2,
                    false,
                ],
            'String Inequality' =>
                [
                    'hello',
                    'world',
                    false,
                ],
            'Boolean Inequality' =>
                [
                    true,
                    false,
                    false,
                ],
        ];
    }

    /** @return array<array-key, array{0: array<mixed>, 1: array<mixed>, 2: bool}> */
    public static function getTestAppendEachData(): array
    {
        return [
            'Array equality' =>
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 3, 4, 5],
                    true,
                ],
            'Array inequality' =>
                [
                    ['z', 'b', 'c', 'd'],
                    ['k', 'b', 'c', 'd'],
                    false,
                ],
            'Array different size' =>
                [
                    [1, 2, 3],
                    [1, 2, 3, 4],
                    false,
                ],
            'Associative Array' =>
                [
                    ['a' => 1, 'b' => 2],
                    ['a' => 1, 'b' => 2],
                    true,
                ],
            'Associative Array inequality' =>
                [
                    ['a' => 1, 'b' => 2],
                    ['a' => 1, 'z' => 2],
                    false,
                ],
            'Multilevel Associative Array' =>
                [
                    ['a' => 1, 'b' => ['1', '2', 'z' => 'k']],
                    ['a' => 1, 'b' => ['1', '2', 'z' => 'k']],
                    true,
                ],
            'Multilevel Associative Array Inequality' =>
                [
                    ['a' => 1, 'b' => ['1', '2', 'z' => 'k']],
                    ['a' => 1, 'b' => ['1', '2', 'q' => 'k']],
                    false,
                ],
        ];
    }

    /** @return array<array-key, array{0: object, 1: object, 2: bool}> */
    public static function getTestAppendObjectData(): array
    {
        $stdClass = new stdClass();

        $equality = $this->createMock(Equality::class);
        $equality
            ->expects(static::once())
            ->method('equals')
            ->with($equality)
            ->willReturn(true);

        return [
            'Object equality without EqualityInterface' =>
                [
                    $stdClass,
                    $stdClass,
                    true,
                ],
            'Object equality with EqualityInterface' =>
                [
                    $equality,
                    $equality,
                    true,
                ],
            'Object inequality without EqualityInterface' =>
                [
                    new stdClass(),
                    new stdClass(),
                    false,
                ],
        ];
    }

    /** @return array<array-key, array{0: float, 1: float, 2: bool}> */
    public static function getTestAppendFloatData(): array
    {
        return [
            'Float Equality' =>
                [
                    3.14000000000000001,
                    3.14000000000000002,
                    true,
                ],
            'Float Inequality' =>
                [
                    3.140000001,
                    3.140000002,
                    false,
                ],
        ];
    }

    /** @return array{0: array{0: array<int>, 1: int}, 1: array{0: float, 1:string}} */
    public static function getTestAppendMixedData(): array
    {
        return [
            [
                [1, 2, 3, 4],
                5,
            ],
            [
                0.5,
                'Hello',
            ],
        ];
    }

    /** @return array{0: array<int>, 1: array<float>, 2: array<Equality>, 3: array<array<int>>, 4: array<array<int>>} */
    public static function getClonePointData(): array // phpcs:disable
    {
        $equality = $this->createMock(Equality::class);
        $equality->method('equals')
                 ->with($equality)
                 ->willReturn(true);

        return [
            [ 1, 5 ],
            [  0.5, 0.2 ],
            [ $equality, $equality],
            [
                [1, 2, 4],
                [4, 5, 6, 7],
            ],
            [
                [], []
            ]
        ];
    }
}
