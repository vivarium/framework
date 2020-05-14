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
use Vivarium\Collection\Set\SortedSet;
use Vivarium\Collection\Test\Stub\PairComparator;
use Vivarium\Comparator\IntegerComparator;
use Vivarium\Comparator\StringComparator;

/**
 * @coversDefaultClass \Vivarium\Collection\Set\SortedSet
 */
final class SortedSetTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::add()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testAdd() : void
    {
        $set = new SortedSet(new IntegerComparator(), 5, 2, 4, 3, 1);
        $set->add(3);
        $set->add(6);

        $expected = [1, 2, 3, 4, 5, 6];

        static::assertCount(6, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::__construct()
     * @covers ::remove()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testRemove() : void
    {
        $set = new SortedSet(new IntegerComparator(), 5, 2, 3, 1, 7);
        $set->remove(3);

        $expected = [1, 2, 5, 7];

        static::assertCount(4, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::clear()
     * @covers ::isEmpty()
     */
    public function testClear() : void
    {
        $set = new SortedSet(new IntegerComparator(), 3, 2, 1);
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

        $set   = SortedSet::fromArray(new IntegerComparator(), [3, 2, 1, 3, 1, 3]);
        $index = 0;
        foreach ($set as $item) {
            static::assertEquals($expected[$index], $item);
            ++$index;
        }
    }

    /**
     * @covers ::contains()
     */
    public function testContains() : void
    {
        $set = new SortedSet(new StringComparator(), 'c', 'd', 'e', 'a');

        static::assertTrue($set->contains('d'));
        static::assertFalse($set->contains('z'));
    }

    /**
     * @covers ::contains()
     */
    public function testContainsWithObjects() : void
    {
        $set = new SortedSet(
            new PairComparator(),
            new Pair(42, 'a'),
            new Pair(27, 'b'),
            new Pair(11, 'c'),
        );

        $contains = new Pair(11, 'c');

        static::assertTrue($set->contains($contains));
    }

    /**
     * @covers ::union()
     * @covers ::add()
     * @covers ::toArray()
     * @covers ::emptySet()
     */
    public function testUnion() : void
    {
        $set1 = new SortedSet(new IntegerComparator(), 5, 3, 2, 42, 7);
        $set2 = new SortedSet(new IntegerComparator(), 6, 27, 1, 3, 7);

        $set = $set1->union($set2);

        $expected = [1, 2, 3, 5, 6, 7, 27, 42];

        static::assertCount(8, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /**
     * @covers ::intersection()
     * @covers ::count()
     * @covers ::toArray()
     * @covers ::emptySet()
     */
    public function testIntersection() : void
    {
        $set1 = new SortedSet(new IntegerComparator(), 4, 5, 2, 1, 3);
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
     * @covers ::emptySet()
     */
    public function testDifference() : void
    {
        $set1 = new SortedSet(new IntegerComparator(), 4, 5, 2, 1, 3);
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
        $set    = new SortedSet(new IntegerComparator(), 6, 4, 3, 2, 1, 5);
        $subset = new SortedSet(new IntegerComparator(), 2, 3, 1);

        static::assertTrue($subset->isSubsetOf($set));
        static::assertFalse($set->isSubsetOf($subset));
    }
}
