<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Map;

use Iterator;
use Vivarium\Collection\Pair\Pair;
use Vivarium\Equality\Equal;
use function count;
use function is_int;
use function is_string;

/**
 * @template K
 * @template V
 * @template-implements Map<K, V>
 */
abstract class CommonMap implements Map
{
    /**
     * @param mixed $value
     *
     * @phpstan-param V $value
     */
    public function containsValue($value) : bool
    {
        foreach ($this as $element) {
            if (Equal::areEquals($value, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return V[]
     */
    public function values() : array
    {
        $values = [];
        foreach ($this->pairs() as $pair) {
            $values[] = $pair->getValue();
        }

        return $values;
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return K[]
     */
    public function keys() : array
    {
        $keys = [];
        foreach ($this->pairs() as $pair) {
            $keys[] = $pair->getKey();
        }

        return $keys;
    }

    public function count() : int
    {
        return count($this->pairs());
    }

    public function isEmpty() : bool
    {
        return $this->count() === 0;
    }

    /**
     * @return Iterator<Pair>
     *
     * @phpstan-return MapIterator<K, V>
     */
    public function getIterator() : Iterator
    {
        return new MapIterator($this->pairs());
    }

    /**
     * @param mixed $key
     *
     * @return int|string
     */
    protected function hash($key)
    {
        return $this->isPossibleKey($key) ? $key : Equal::hash($key);
    }

    /**
     * @param mixed $key
     */
    protected function isPossibleKey($key) : bool
    {
        return is_string($key) || is_int($key);
    }
}
