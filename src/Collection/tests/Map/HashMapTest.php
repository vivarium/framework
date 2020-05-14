<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Map;

use DateTimeImmutable;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Collection\Map\HashMap;
use Vivarium\Collection\Pair\Pair;
use function count;
use function rand;

/**
 * @coversDefaultClass \Vivarium\Collection\Map\HashMap
 */
final class HashMapTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::count
     * @covers ::isEmpty()
     */
    public function testEmpty() : void
    {
        $map = new HashMap();

        static::assertCount(0, $map);
        static::assertTrue($map->isEmpty());
    }

    /**
     * @covers ::put()
     * @covers ::count()
     * @covers ::hash()
     * @covers ::isPossibleKey()
     */
    public function testPut() : void
    {
        $map = new HashMap();

        $map->put(4, 'd');
        $map->put(7, 'a');
        $map->put(6, 't');
        $map->put(1, 'z');

        static::assertCount(4, $map);
        static::assertEquals('d', $map->get(4));
    }

    /**
     * @covers ::get()
     */
    public function testGet() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map = new HashMap();

        for ($i = 0; $i < count($keys); $i++) {
            $map->put($keys[$i], $values[$i]);
        }

        $index = rand(0, count($keys) - 1);

        $value = $map->get($keys[$index]);

        static::assertEquals($values[$index], $value);
    }

    /**
     * @covers ::get()
     */
    public function testGetWithEquality() : void
    {
        $pair = new Pair(
            new DateTimeImmutable(),
            new DateTimeImmutable()
        );

        $map = new HashMap();

        $map->put($pair, 1);

        static::assertEquals(1, $map->get($pair));
    }

    /**
     * @covers ::get()
     */
    public function testGetException() : void
    {
        static::expectException(OutOfBoundsException::class);
        static::expectExceptionMessage('The provided key is not present.');

        $map = new HashMap();
        $map->get(new stdClass());
    }

    /**
     * @covers ::remove()
     * @covers ::containsKey()
     * @covers ::count()
     * @covers ::fromKeyValue()
     */
    public function testRemove() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map   = HashMap::fromKeyValue($keys, $values);
        $index = rand(0, count($keys) - 1);

        $map->remove($keys[$index]);

        static::assertCount(count($keys) - 1, $map);
        static::assertFalse($map->containsKey($keys[$index]));
    }

    /**
     * @covers ::containsValue()
     * @covers ::fromKeyValue()
     */
    public function testContainsValue() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map   = HashMap::fromKeyValue($keys, $values);
        $index = rand(0, count($values) - 1);

        static::assertTrue($map->containsValue($values[$index]));
        static::assertFalse($map->containsValue('str'));
    }

    /**
     * @covers ::values()
     * @covers ::fromKeyValue()
     */
    public function testValues() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map    = HashMap::fromKeyValue($keys, $values);
        $actual = $map->values();

        static::assertEquals($values, $actual);
    }

    /**
     * @covers ::keys()
     * @covers ::fromKeyValue()
     */
    public function testKeys() : void
    {
        $keys   = ['a', 'b', 'c', 'd'];
        $values = [1, 2, 3, 4];

        $map    = HashMap::fromKeyValue($keys, $values);
        $actual = $map->keys();

        static::assertEquals($keys, $actual);
    }

    /**
     * @covers ::pairs()
     * @covers ::fromKeyValue()
     */
    public function testPairs() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map = HashMap::fromKeyValue($keys, $values);

        $pairs = $map->pairs();
        for ($i = 0; $i < count($keys); $i++) {
            static::assertEquals($keys[$i], $pairs[$i]->getKey());
            static::assertEquals($values[$i], $pairs[$i]->getValue());
        }
    }

    /**
     * @covers ::clear()
     * @covers ::isEmpty()
     * @covers ::count()
     * @covers ::fromKeyValue()
     */
    public function testClear() : void
    {
        $keys   = [1, 2, 3, 4];
        $values = ['a', 'b', 'c', 'd'];

        $map = HashMap::fromKeyValue($keys, $values);
        $map->clear();

        static::assertEquals(0, $map->count());
        static::assertTrue($map->isEmpty());
    }

    /**
     * @covers ::getIterator
     */
    public function testGetIterator() : void
    {
        $map = new HashMap(
            new Pair('a', 1),
            new Pair('b', 2),
            new Pair('c', 3)
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
