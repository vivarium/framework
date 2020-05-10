<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Map;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Map\MapIterator;
use Vivarium\Collection\Pair\Pair;
use function array_keys;
use function array_values;

/**
 * @coversDefaultClass \Vivarium\Collection\Map\MapIterator
 */
final class MapIteratorTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::rewind()
     * @covers ::valid()
     * @covers ::key()
     * @covers ::current()
     * @covers ::next()
     */
    public function testMapIterator() : void
    {
        $date1 = new DateTimeImmutable();
        $date2 = new DateTimeImmutable();
        $date3 = new DateTimeImmutable();
        $date4 = new DateTimeImmutable();

        $expected = [
            1  => $date2,
            5  => $date3,
            42 => $date4,
            0  => $date1,
        ];

        $pairs = [];
        foreach ($expected as $key => $value) {
            $pairs[] = new Pair($key, $value);
        }

        $iterator = new MapIterator($pairs);
        $this->iterate($iterator, $expected);

        $iterator->rewind();

        $this->iterate($iterator, $expected);
    }

    /**
     * @param array<int, DateTimeImmutable> $expected
     * @param int[]                         $keys
     */
    private function checkKeys(array $expected, array $keys) : void
    {
        foreach (array_keys($expected) as $key => $value) {
            static::assertEquals($value, $keys[$key]);
        }
    }

    /**
     * @param array<int, DateTimeImmutable> $expected
     * @param DateTimeImmutable[]           $values
     */
    private function checkValues(array $expected, array $values) : void
    {
        foreach (array_values($expected) as $key => $value) {
            static::assertEquals($value, $values[$key]);
        }
    }

    /**
     * @param array<int, DateTimeImmutable> $expected
     *
     * @psalm-param MapIterator<int, DateTimeImmutable> $iterator
     */
    private function iterate(MapIterator $iterator, array $expected) : void
    {
        $keys   = [];
        $values = [];
        while ($iterator->valid()) {
            $keys[]   = $iterator->key();
            $values[] = $iterator->current();
            $iterator->next();
        }

        $this->checkKeys($expected, $keys);
        $this->checkValues($expected, $values);
    }
}
