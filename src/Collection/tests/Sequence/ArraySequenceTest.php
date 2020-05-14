<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Sequence;

use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Pair\Pair;
use Vivarium\Collection\Sequence\ArraySequence;
use Vivarium\Collection\Test\Stub\PairComparator;
use Vivarium\Comparator\IntegerComparator;

/**
 * @coversDefaultClass \Vivarium\Collection\Sequence\ArraySequence
 */
final class ArraySequenceTest extends TestCase
{
    /**
     * @covers ::add()
     * @covers ::count()
     * @covers ::toArray()
     * @covers ::fromArray()
     */
    public function testAdd() : void
    {
        $list = ArraySequence::fromArray([1, 5, 0, -1]);
        $list->add(42);
        $list->add(23);

        $expected = new ArraySequence(1, 5, 0, -1, 42, 23);

        static::assertCount(6, $list);
        static::assertEquals($expected->toArray(), $list->toArray());
    }

    /**
     * @covers ::__construct()
     * @covers ::count()
     * @covers ::add()
     * @covers ::remove()
     * @covers ::toArray()
     */
    public function testRemove() : void
    {
        $list = new ArraySequence(1, 5, 0, -1);
        $list->add(42);
        $list->add(23);

        $list->remove(1);
        $list->remove(0);

        $expected = new ArraySequence(5, -1, 42, 23);

        static::assertCount(4, $list);
        static::assertEquals($expected->toArray(), $list->toArray());
    }

    /**
     * @covers ::contains()
     */
    public function testContains() : void
    {
        $list = new ArraySequence(5, 3, 42, 11, 0, -1);

        static::assertTrue($list->contains(5));
        static::assertTrue($list->contains(-1));
        static::assertTrue($list->contains(42));
        static::assertFalse($list->contains(117));
    }

    /**
     * @covers ::clear()
     * @covers ::count()
     * @covers ::isEmpty()
     */
    public function testClear() : void
    {
        $list = new ArraySequence(1, 2, 3, 4, 5);
        $list->clear();

        static::assertCount(0, $list);
        static::assertTrue($list->isEmpty());
    }

    /**
     * @covers ::getIterator()
     * @covers ::fromArray()
     */
    public function testGetIterator() : void
    {
        $expected = [1, 2, 3, 4, 5];

        $list = ArraySequence::fromArray($expected);

        $index = 0;
        foreach ($list as $item) {
            static::assertEquals($expected[$index], $item);
            ++$index;
        }
    }

    /**
     * @covers ::getAtIndex()
     * @covers ::checkBounds()
     */
    public function testGetAtIndex() : void
    {
        $list    = new ArraySequence(1, 2, 3, 4, 5);
        $element = $list->getAtIndex(2);

        static::assertEquals(3, $element);
    }

    /**
     * @covers ::setAtIndex()
     */
    public function testSetAtIndex() : void
    {
        $list = new ArraySequence(1, 2, 3, 4, 5);
        $list->setAtIndex(1, 5);

        static::assertEquals(5, $list->getAtIndex(1));
    }

    /**
     * @covers ::removeAtIndex()
     */
    public function testRemoveAtIndex() : void
    {
        $list = new ArraySequence(1, 2, 3, 4, 5);
        $list->removeAtIndex(1);

        static::assertEquals([1, 3, 4, 5], $list->toArray());
    }

    /**
     * @covers ::search()
     */
    public function testSearch() : void
    {
        /** @psalm-var ArraySequence<int> $list */
        $list = new ArraySequence(5, 2, 42, 7, 11);

        static::assertEquals(0, $list->search(5));
        static::assertEquals(2, $list->search(42));
        static::assertEquals(-1, $list->search(35));

        $list->clear();
        static::assertEquals(-1, $list->search(2));
    }

    /**
     * @covers ::search()
     */
    public function testSearchWithEquality() : void
    {
        $list = new ArraySequence(
            new Pair(1, 'a'),
            new Pair(2, 'b'),
            new Pair(3, 'c')
        );

        $search = new Pair(2, 'b');

        static::assertEquals(1, $list->search($search));
    }

    /**
     * @covers ::sort()
     * @covers ::toArray()
     */
    public function testSort() : void
    {
        $list = new ArraySequence(5, 2, 7, 8, 1);
        $list->sort(new IntegerComparator());

        $expected = new ArraySequence(1, 2, 5, 7, 8);

        static::assertEquals($expected->toArray(), $list->toArray());
    }

    /**
     * @covers ::sort()
     * @covers ::toArray()
     */
    public function testSortWithObject() : void
    {
        $pair1 = new Pair(42, 'a');
        $pair2 = new Pair(27, 'b');
        $pair3 = new Pair(11, 'c');

        $list     = new ArraySequence($pair2, $pair1, $pair3);
        $expected = new ArraySequence($pair3, $pair2, $pair1);

        $list->sort(new PairComparator());

        static::assertEquals($expected->toArray(), $list->toArray());
    }
}
