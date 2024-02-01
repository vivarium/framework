<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Collection\Set;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Collection\Set\HashSet;
use Vivarium\Equality\Equal;
use Vivarium\Equality\Equality;

use function count;

/** @coversDefaultClass \Vivarium\Collection\Set\HashSet */
class HashSetTest extends TestCase
{
    /** @covers ::__construct() */
    public function testEmptyConstructor(): void
    {
        $set = new HashSet();

        static::assertCount(0, $set);
    }

    /**
     * @covers ::add()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testAdd(): void
    {
        /** @var HashSet<int> $set */
        $set = new HashSet(1, 2, 3, 4);
        $set = $set
            ->add(1)
            ->add(1)
            ->add(2)
            ->add(5);

        $expected = [1, 2, 3, 4, 5];

        static::assertCount(5, $set);
        static::assertEquals($expected, $set->toArray());
        static::assertNotSame($set, $set->add(42));
    }

    /**
     * @covers ::__construct()
     * @covers ::remove()
     * @covers ::count()
     */
    public function testRemove(): void
    {
        $elements = [1, 2, 3, 4, 5];

        $set = HashSet::fromArray($elements);
        $set = $set->remove(3);

        $expected = [1, 2, 4, 5];

        static::assertCount(count($expected), $set);
        static::assertEquals($expected, $set->toArray());
        static::assertNotSame($set, $set->remove(2));
    }

    /** @covers ::contains() */
    public function testContains(): void
    {
        /** @var string[] $elements */
        $elements = ['a', 'b', 'c', 'd'];

        $set = HashSet::fromArray($elements);

        static::assertTrue($set->contains('b'));
        static::assertFalse($set->contains('z'));
    }

    /** @covers ::contains() */
    public function testContainsWithObjects(): void
    {
        $stub1 = $this->createMock(Equality::class);
        $stub2 = $this->createMock(Equality::class);
        $stub3 = $this->createMock(Equality::class);

        $stub2->method('equals')
              ->willReturnMap(
                  [
                      [$stub1, false],
                      [$stub2, true],
                      [$stub3, false],
                  ],
              );

        $set = new HashSet($stub1, $stub1, $stub2, $stub3);

        static::assertTrue($set->contains($stub2));
    }

    /**
     * @covers ::union()
     * @covers ::add()
     * @covers ::toArray()
     */
    public function testUnion(): void
    {
        /** @var HashSet<int> $set1 */
        $set1 = new HashSet(1, 3, 5, 7, 42);

        /** @var HashSet<int> $set2 */
        $set2 = new HashSet(2, 4, 6, 8, 42);

        $set = $set1->union($set2);

        $expected = [1, 3, 5, 7, 42, 2, 4, 6, 8];

        static::assertCount(9, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /** @covers ::union() */
    public function testUnionImmutability(): void
    {
        /** @var HashSet<int> $set1 */
        $set1 = new HashSet(1, 2, 3);

        /** @var HashSet<int> $set2 */
        $set2 = new HashSet();

        $set = $set1->union($set2);

        static::assertNotSame($set, $set1);
    }

    /**
     * @covers ::intersection()
     * @covers ::count()
     * @covers ::toArray()
     */
    public function testIntersection(): void
    {
        /** @var HashSet<int> $set1 */
        $set1 = new HashSet(1, 2, 3, 4, 5);

        /** @var HashSet<int> $set2 */
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
    public function testDifference(): void
    {
        /** @var HashSet<int> $set1 */
        $set1 = new HashSet(1, 2, 4, 5, 3);

        /** @var HashSet<int> $set2 */
        $set2 = new HashSet(4, 5, 6, 7, 8);

        $set = $set1->difference($set2);

        $expected = [1, 2, 3];

        static::assertCount(3, $set);
        static::assertEquals($expected, $set->toArray());
    }

    /** @covers ::isSubsetOf() */
    public function testIsSubsetOf(): void
    {
        /** @var HashSet<int> $set */
        $set = new HashSet(1, 2, 3, 4, 5, 6);

        /** @var HashSet<int> $subset */
        $subset = new HashSet(1, 2, 3);

        static::assertTrue($subset->isSubsetOf($set));
        static::assertFalse($set->isSubsetOf($subset));
    }

    /**
     * @covers ::clear()
     * @covers ::isEmpty()
     */
    public function testClear(): void
    {
        $set = new HashSet(1, 2, 3);
        $set = $set->clear();

        static::assertCount(0, $set);
        static::assertTrue($set->isEmpty());
    }

    /** @covers ::getIterator() */
    public function testGetIterator(): void
    {
        /** @var array<int> $expected */
        $expected = [1, 2, 3];

        $set   = HashSet::fromArray([1, 1, 2, 2, 3, 3]);
        $index = 0;
        foreach ($set as $item) {
            static::assertEquals($expected[$index], $item);
            ++$index;
        }
    }

    /** @covers ::fromArray() */
    public function testFromArray(): void
    {
        /** @var int[] $values */
        $values = [1, 1, 2, 2, 3, 3];

        $set1 = HashSet::fromArray($values);
        $set2 = new HashSet(1, 1, 2, 2, 3, 3);

        static::assertTrue(Equal::areEquals($set1, $set2));
    }

    /** @covers ::equals() */
    public function testEquals(): void
    {
        $set1 = new HashSet(1, 2, 3, 3, 1);
        $set2 = new HashSet(1, 2, 3, 3, 1);
        $set3 = new HashSet(4, 4, 5, 2, 3);

        static::assertTrue($set1->equals($set1));
        static::assertTrue($set1->equals($set2));
        static::assertFalse($set1->equals($set3));
        static::assertFalse($set1->equals(new stdClass()));
    }

    /** @covers ::hash() */
    public function testHash(): void
    {
        $set1 = new HashSet(1, 2, 3, 3, 1);
        $set2 = new HashSet(1, 2, 3, 3, 1);
        $set3 = new HashSet(4, 4, 5, 2, 3);

        static::assertSame($set1->hash(), $set1->hash());
        static::assertSame($set1->hash(), $set2->hash());
        static::assertNotSame($set1->hash(), $set3->hash());
    }
}
