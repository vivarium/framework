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
use Vivarium\Collection\Set\SetIterator;
use function array_keys;

/**
 * @coversDefaultClass \Vivarium\Collection\Set\SetIterator
 */
final class SetIteratorTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::rewind()
     * @covers ::valid()
     * @covers ::key()
     * @covers ::current()
     * @covers ::next()
     */
    public function testSetIterator() : void
    {
        $expected = [
            1 => 2,
            3 => 4,
            5 => 6,
            7 => 8,
        ];

        $pairs = [];
        foreach ($expected as $key => $value) {
            $pairs[] = new Pair($key, $value);
        }

        $iterator = new SetIterator($pairs);
        $this->iterate($iterator, $expected);

        $iterator->rewind();

        $this->iterate($iterator, $expected);
    }

    /**
     * @template T
     *
     * @phpstan-param T[] $expected
     * @phpstan-param T[] $values
     */
    private function checkValues(array $expected, array $values) : void
    {
        foreach (array_keys($expected) as $key => $value) {
            static::assertEquals($value, $values[$key]);
        }
    }

    /**
     * @param mixed[] $expected
     *
     * @template T
     *
     * @phpstan-param SetIterator<T> $iterator
     * @phpstan-param T[] $expected
     */
    private function iterate(SetIterator $iterator, array $expected) : void
    {
        $values = [];
        while ($iterator->valid()) {
            $values[$iterator->key()] = $iterator->current();
            $iterator->next();
        }

        $this->checkValues($expected, $values);
    }
}
