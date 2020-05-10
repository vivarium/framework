<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Map;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Map\SortedMap;
use Vivarium\Collection\Pair\Pair;
use Vivarium\Comparator\IntegerComparator;
use Vivarium\Comparator\StringComparator;
use function count;
use function usort;

/**
 * @coversDefaultClass \Vivarium\Collection\Map\SortedMap
 */
final class SortedMapTest extends TestCase
{
    /**
     * @covers ::keys()
     * @covers ::fromKeyValue()
     */
    public function testKeyOrder() : void
    {
        $keys   = ['c', 'b', 'a', 'd'];
        $values = [1, 2, 3, 4];

        $map = SortedMap::fromKeyValue(new StringComparator(), $keys, $values);

        $expected = ['a', 'b', 'c', 'd'];
        $keys     = $map->keys();

        static::assertEquals($expected, $keys);
    }

    /**
     * @covers ::__construct()
     * @covers ::put()
     * @covers ::count()
     * @covers ::search()
     * @covers ::searchRecursion()
     * @covers ::sign()
     * @covers ::fromKeyValue()
     */
    public function testPut() : void
    {
        $keys   = ['c', 'b', 'a', 'd'];
        $values = [1, 2, 3, 4];

        $map = SortedMap::fromKeyValue(new StringComparator(), $keys, $values);

        $map->put('f', 42);
        $map->put('a', 5);

        static::assertCount(5, $map);
        static::assertEquals(5, $map->get('a'));
    }

    /**
     * @covers ::put()
     * @covers ::values()
     */
    public function testDoublePut() : void
    {
        $map = new SortedMap(new StringComparator());
        $map->put('c', 1);
        $map->put('c', 12);
        $map->put('a', 7);
        $map->put('b', 2);

        $keys   = ['a', 'b', 'c'];
        $values = [7, 2, 12];

        static::assertCount(3, $map);
        static::assertEquals($keys, $map->keys());
        static::assertEquals($values, $map->values());
    }

    /**
     * @covers ::search()
     * @covers ::sign()
     */
    public function testSearch() : void
    {
        $map = new SortedMap(new StringComparator());
        $map->put('Hello', 1);
        $map->put('H', 1);
        $map->put('Ab', 1);
        $map->put('A', 1);;

        $keys = ['A', 'Ab', 'H', 'Hello'];
        static::assertEquals($keys, $map->keys());
    }

    /**
     * @covers ::get()
     */
    public function testGet() : void
    {
        $map = new SortedMap(
            new IntegerComparator(),
            new Pair(0, 'a')
        );

        $value = $map->get(0);

        static::assertEquals('a', $value);
    }

    /**
     * @covers ::get()
     */
    public function testGetNotFound() : void
    {
        static::expectException(OutOfBoundsException::class);
        static::expectExceptionMessage('The provided key is not present.');

        $map = new SortedMap(new IntegerComparator());

        $map->get(1);
    }

    /**
     * @covers ::__construct()
     * @covers ::remove()
     * @covers ::containsKey()
     * @covers ::containsValue()
     * @covers ::fromKeyValue()
     */
    public function testRemove() : void
    {
        $keys   = [5, 3, 2, 1, 7];
        $values = [7, 5, 3, 8, 9];

        $map = SortedMap::fromKeyValue(new IntegerComparator(), $keys, $values);

        $key   = 3;
        $value = 5;

        static::assertTrue($map->containsKey($key));
        static::assertTrue($map->containsValue($value));

        $map->remove($key);

        static::assertFalse($map->containsKey($key));
        static::assertFalse($map->containsValue($value));
    }

    /**
     * @covers ::put()
     * @covers ::remove()
     */
    public function testRemoveOnFirstElement() : void
    {
        $map = new SortedMap(new IntegerComparator());
        $map->put(0, 1);
        $map->put(1, 1);

        static::assertTrue($map->containsKey(0));
        static::assertTrue($map->containsKey(1));
        static::assertFalse($map->containsKey(2));

        $map->remove(0);

        static::assertFalse($map->containsKey(0));
        static::assertFalse($map->containsKey(2));
        static::assertTrue($map->containsKey(1));
    }

    /**
     * @covers ::pairs()
     * @covers ::fromKeyValue()
     */
    public function testPairs() : void
    {
        $keys   = [1, 2, 3, 4, 5];
        $values = ['a', 'b', 'c', 'd', 'e'];

        $map = SortedMap::fromKeyValue(new IntegerComparator(), $keys, $values);

        usort($keys, new IntegerComparator());

        $pairs = $map->pairs();
        for ($i = 0; $i < count($keys); $i++) {
            static::assertEquals($keys[$i], $pairs[$i]->getKey());
        }
    }

    /**
     * @covers ::clear()
     * @covers ::isEmpty()
     * @covers ::fromKeyValue()
     */
    public function testClear() : void
    {
        $keys   = [1, 2, 3, 4, 5];
        $values = ['a', 'b', 'c', 'd', 'e'];

        $map = SortedMap::fromKeyValue(new IntegerComparator(), $keys, $values);
        $map->clear();

        static::assertCount(0, $map);
        static::assertTrue($map->isEmpty());
    }

    /**
     * @covers ::getIterator
     */
    public function testGetIterator() : void
    {
        $map = new SortedMap(
            new StringComparator(),
            new Pair('c', 3),
            new Pair('b', 2),
            new Pair('a', 1)
        );

        $order = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ];

        $iterator = $map->getIterator();
        foreach ($order as $key => $value) {
            static::assertEquals($key, $iterator->key());
            static::assertEquals($value, $iterator->current());
            $iterator->next();
        }
    }
}
