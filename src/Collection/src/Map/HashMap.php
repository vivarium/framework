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
use function array_values;
use function count;

/**
 * @template K
 * @template V
 * @template-extends CommonMap<K, V>
 */
final class HashMap extends CommonMap
{
    /**
     * @var Pair[]
     * @phpstan-var Pair<K, V>[]
     */
    private array $pairs;

    /**
     * @phpstan-param Pair<K, V> ...$elements
     */
    public function __construct(Pair ...$elements)
    {
        $this->pairs = $elements;
    }

    /**
     * @template K0
     * @template V0
     * @phpstan-param K0[] $keys
     * @phpstan-param V0[] $values
     * @phpstan-return HashMap<K0, V0>
     */
    public static function fromKeyValue(array $keys, array $values) : HashMap
    {
        (new IsSameOf(count($keys)))
            ->assert(count($values));

        $map = new HashMap();
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
        $hash = $this->hash($key);

        $this->pairs[$hash] = new Pair($key, $value);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     *
     * @phpstan-return V
     */
    public function get($key)
    {
        $hash = $this->hash($key);

        if (! isset($this->pairs[$hash])) {
            throw new OutOfBoundsException('The provided key is not present.');
        }

        return $this->pairs[$hash]->getValue();
    }

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function remove($key) : void
    {
        $hash = $this->hash($key);
        unset($this->pairs[$hash]);
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

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function containsKey($key) : bool
    {
        $hash = $this->hash($key);

        return isset($this->pairs[$hash]);
    }

    public function clear() : void
    {
        $this->pairs = [];
    }
}
