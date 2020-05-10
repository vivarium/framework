<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Set;

use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Pair\Pair;
use Vivarium\Collection\Set\HashSet;
use function count;

/**
 * @coversDefaultClass \Vivarium\Collection\Set\HashSet
 */
final class HashSetTest extends TestCase
{
    /**
     * @covers ::__construct()
     */
    public function testEmptyConstructor() : void
    {
        $set = new HashSet();

        static::assertCount(0, $set);
    }

    /**
     * @covers ::add()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testAdd() : void
    {
        /** @psalm-var HashSet<int> $set */
        $set = new HashSet(1, 2, 3, 4);
        $set->add(1);
        $set->add(1);
        $set->add(2);
        $set->add(5);

        $expected = [1, 2, 3, 4, 5];

        static::assertCount(5, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::__construct()
     * @covers ::remove()
     * @covers ::count()
     * @covers ::fromArray()
     */
    public function testRemove() : void
    {
        $elements = [1, 2, 3, 4, 5];

        $set = HashSet::fromArray($elements);
        $set->remove(3);

        $expected = [1, 2, 4, 5];

        static::assertCount(count($expected), $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::contains()
     * @covers ::fromArray()
     */
    public function testContains() : void
    {
        $elements = ['a', 'b', 'c', 'd'];

        /** @psalm-var HashSet<string> $set */
        $set = HashSet::fromArray($elements);

        static::assertTrue($set->contains('b'));
        static::assertFalse($set->contains('z'));
    }

    /**
     * @covers ::contains()
     */
    public function testContainsWithObjects() : void
    {
        $set = new HashSet(
            new Pair(42, 'a'),
            new Pair(27, 'b'),
            new Pair(11, 'c')
        );

        $contains = new Pair(42, 'a');

        static::assertTrue($set->contains($contains));
    }

    /**
     * @covers ::union()
     * @covers ::add()
     * @covers ::toArray()
     */
    public function testUnion() : void
    {
        $set1 = new HashSet(1, 3, 5, 7, 42);
        $set2 = new HashSet(2, 4, 6, 8, 42);

        $set = $set1->union($set2);

        $expected = [1, 3, 5, 7, 42, 2, 4, 6, 8];

        static::assertCount(9, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::intersection()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testIntersection() : void
    {
        /** @psalm-var HashSet<int> $set1 */
        $set1 = new HashSet(1, 2, 3, 4, 5);
        /** @psalm-var HashSet<int> $set2 */
        $set2 = new HashSet(4, 5, 6, 7, 8);

        $set = $set1->intersection($set2);

        $expected = [4, 5];

        static::assertCount(2, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::difference()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testDifference() : void
    {
        /** @psalm-var HashSet<int> $set1 */
        $set1 = new HashSet(1, 2, 3, 4, 5);
        /** @psalm-var HashSet<int> $set2 */
        $set2 = new HashSet(4, 5, 6, 7, 8);

        $set = $set1->difference($set2);

        $expected = [1, 2, 3];

        static::assertCount(3, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::isSubsetOf()
     */
    public function testIsSubsetOf() : void
    {
        /** @psalm-var HashSet<int> $set */
        $set = new HashSet(1, 2, 3, 4, 5, 6);
        /** @psalm-var HashSet<int> $subset */
        $subset = new HashSet(1, 2, 3);

        static::assertTrue($subset->isSubsetOf($set));
        static::assertFalse($set->isSubsetOf($subset));
    }

    /**
     * @covers ::clear()
     * @covers ::isEmpty()
     */
    public function testClear() : void
    {
        $set = new HashSet(1, 2, 3);
        $set->clear();

        static::assertTrue($set->isEmpty());
        static::assertCount(0, $set);
    }

    /**
     * @covers ::getIterator()
     * @covers ::fromArray()
     */
    public function testGetIterator() : void
    {
        $expected = [1, 2, 3];

        $set   = HashSet::fromArray([1, 1, 2, 2, 3, 3]);
        $index = 0;
        foreach ($set as $item) {
            static::assertEquals($expected[$index], $item);
            ++$index;
        }
    }
}
