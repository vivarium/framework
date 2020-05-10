<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Map;

use OutOfBoundsException;
use Vivarium\Assertion\Comparison\IsSameOf;
use Vivarium\Collection\Pair\Pair;
use Vivarium\Comparator\Comparator;
use function abs;
use function array_merge;
use function array_slice;
use function array_values;
use function count;
use function intval;
use function usort;

/**
 * @template K
 * @template V
 * @template-extends CommonMap<K, V>
 */
final class SortedMap extends CommonMap
{
    /**
     * @var Pair[]
     * @phpstan-var Pair<K, V>[]
     */
    private array $pairs;

    /** @phpstan-var Comparator<K>  */
    private Comparator $comparator;

    /**
     * @phpstan-param Comparator<K> $comparator
     * @phpstan-param Pair<K, V> ...$pairs
     */
    public function __construct(Comparator $comparator, Pair ...$pairs)
    {
        $this->pairs      = $pairs;
        $this->comparator = $comparator;

        usort($this->pairs, static function ($a, $b) use ($comparator) : int {
            return $comparator($a->getKey(), $b->getKey());
        });
    }

    /**
     * @template K0
     * @template V0
     * @phpstan-param Comparator<K0> $comparator
     * @phpstan-param K0[] $keys
     * @phpstan-param V0[] $values
     * @phpstan-return SortedMap<K0, V0>
     */
    public static function fromKeyValue(Comparator $comparator, array $keys, array $values) : SortedMap
    {
        (new IsSameOf(count($keys)))
            ->assert(count($values));

        $map = new SortedMap($comparator);
        for ($i = 0; $i < count($keys); $i++) {
            $map->put($keys[$i], $values[$i]);
        }

        return $map;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @phpstan-param K $key
     * @phpstan-param V $value
     */
    public function put($key, $value) : void
    {
        $pair  = new Pair($key, $value);
        $index = $this->search($key);

        if ($index >= 0) {
            $this->pairs[$index] = $pair;

            return;
        }

        $index = abs($index + 1);

        $leftSlice  = array_slice($this->pairs, 0, $index);
        $rightSlice = array_slice($this->pairs, $index, count($this->pairs));

        $this->pairs = array_merge($leftSlice, [$pair], $rightSlice);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     *
     * @phpstan-param K $key
     *
     * @phpstan-return V
     */
    public function get($key)
    {
        $index = $this->search($key);
        if ($index < 0) {
            throw new OutOfBoundsException('The provided key is not present.');
        }

        return $this->pairs[$index]->getValue();
    }

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function remove($key) : void
    {
        $index = $this->search($key);

        unset($this->pairs[$index]);

        $this->pairs = array_values($this->pairs);
    }

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function containsKey($key) : bool
    {
        return $this->search($key) >= 0;
    }

    /**
     * @return Pair[]
     *
     * @phpstan-return Pair<K, V>[]
     */
    public function pairs() : array
    {
        return array_values($this->pairs);
    }

    public function clear() : void
    {
        $this->pairs = [];
    }

    /**
     * @param mixed $key
     */
    private function search($key) : int
    {
        return $this->searchRecursion($key, 0, $this->count());
    }

    /**
     * @param mixed $key
     */
    private function searchRecursion($key, int $start, int $end) : int
    {
        if ($start < $end) {
            $middle = intval(($start + $end) / 2);
            switch ($this->sign($key, $this->pairs[$middle]->getKey())) {
                case -1:
                    return $this->searchRecursion($key, $start, $middle);
                case 1:
                    return $this->searchRecursion($key, $middle + 1, $end);
                default:
                    return $middle;
            }
        }

        return -($start + 1);
    }

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @psalm-param K $first
     * @psalm-param K $second
     */
    private function sign($first, $second) : int
    {
        $sign = $this->comparator->compare($first, $second);
        if ($sign === 0) {
            return $sign;
        }

        return $sign >= 1 ? 1 : -1;
    }
}
