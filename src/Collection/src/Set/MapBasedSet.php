<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use Iterator;
use Vivarium\Collection\Map\Map;

/**
 * @template T
 * @template-extends CommonSet<T>
 */
abstract class MapBasedSet extends CommonSet
{
    protected const PLACEHOLDER = 1;

    /** @phpstan-var Map<T, int>  */
    private Map $map;

    /**
     * @phpstan-param Map<T, int> $map
     */
    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function add($element) : void
    {
        $this->map->put($element, self::PLACEHOLDER);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function remove($element) : void
    {
        $this->map->remove($element);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function contains($element) : bool
    {
        return $this->map->containsKey($element);
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return T[]
     */
    public function toArray() : array
    {
        return $this->map->keys();
    }

    /**
     * @return Iterator<mixed>
     *
     * @phpstan-return Iterator<T>
     */
    public function getIterator() : Iterator
    {
        return new SetIterator($this->map->pairs());
    }

    public function count() : int
    {
        return $this->map->count();
    }

    public function clear() : void
    {
        $this->map->clear();
    }
}
