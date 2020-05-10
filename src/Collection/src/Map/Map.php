<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Map;

use Countable;
use IteratorAggregate;
use Vivarium\Collection\Pair\Pair;

/**
 * @template K
 * @template V
 * @template-extends IteratorAggregate<K, V>
 */
interface Map extends Countable, IteratorAggregate
{
    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @phpstan-param K $key
     * @phpstan-param V $value
     */
    public function put($key, $value) : void;

    /**
     * @param mixed $key
     *
     * @return mixed
     *
     * @phpstan-param K $key
     *
     * @phpstan-return V
     */
    public function get($key);

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function remove($key) : void;

    /**
     * @param mixed $key
     *
     * @phpstan-param K $key
     */
    public function containsKey($key) : bool;

    /**
     * @param mixed $value
     *
     * @phpstan-param V $value
     */
    public function containsValue($value) : bool;

    /**
     * @return mixed[]
     *
     * @phpstan-return V[]
     */
    public function values() : array;

    /**
     * @return mixed[]
     *
     * @phpstan-return K[]
     */
    public function keys() : array;

    /**
     * @return Pair[]
     *
     * @phpstan-return Pair<K, V>[]
     */
    public function pairs() : array;

    public function isEmpty() : bool;

    public function clear() : void;
}
