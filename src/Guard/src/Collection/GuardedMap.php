<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Vivarium\Collection\Map\Map;
use Vivarium\Type\Assertion\IsAssignableVar;
use Vivarium\Type\Tuple;
use Vivarium\Type\Type;
use Vivarium\Type\Typed;

/**
 * @template K
 * @template V
 * @template-implements Map<K, V>
 */
final class GuardedMap implements Map, Typed
{
    private Type $keyType;

    private Type $valueType;

    /** @phpstan-var Map<K, V>  */
    private Map $map;

    /**
     * @phpstan-param Map<K, V> $map
     */
    public function __construct(Type $keyType, Type $valueType, Map $map)
    {
        $this->keyType   = $keyType;
        $this->valueType = $valueType;

        $this->map = $map;
    }

    public function put($key, $value): void
    {
        (new IsAssignableVar($this->keyType))
            ->assert($key);

        (new IsAssignableVar($this->valueType))
            ->assert($value);

        $this->map->put($key, $value);
    }

    public function get($key)
    {
        (new IsAssignableVar($this->keyType))
            ->assert($key);

        return $this->map->get($key);
    }

    public function remove($key): void
    {
        (new IsAssignableVar($this->keyType))
            ->assert($key);

        $this->map->remove($key);
    }

    public function containsKey($key): bool
    {
        (new IsAssignableVar($this->keyType))
            ->assert($key);

        return $this->map->containsKey($key);
    }

    public function containsValue($value): bool
    {
        (new IsAssignableVar($this->valueType))
            ->assert($value);

        return $this->map->containsValue($value);
    }

    public function values(): array
    {
        return $this->map->values();
    }

    public function keys(): array
    {
        return $this->map->keys();
    }

    public function pairs(): array
    {
        return $this->map->pairs();
    }

    public function isEmpty(): bool
    {
        return $this->map->isEmpty();
    }

    public function clear(): void
    {
        $this->map->clear();
    }

    public function getIterator()
    {
        return $this->map->getIterator();
    }

    public function count()
    {
        return $this->map->count();
    }

    public function getTuple() : Tuple
    {
        return new Tuple($this->keyType, $this->valueType);
    }
}
