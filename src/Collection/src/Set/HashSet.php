<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use Vivarium\Collection\Map\HashMap;
use function array_fill;
use function count;

/**
 * @template T
 * @template-extends MapBasedSet<T>
 */
final class HashSet extends MapBasedSet
{
    /**
     * @param mixed ...$elements
     *
     * @phpstan-param T ...$elements
     */
    public function __construct(...$elements)
    {
        parent::__construct(
            HashMap::fromKeyValue(
                $elements,
                array_fill(0, count($elements), self::PLACEHOLDER)
            )
        );
    }

    /**
     * @template T0
     * @phpstan-param T0[] $elements
     * @phpstan-return HashSet<T0>
     */
    public static function fromArray(array $elements) : HashSet
    {
        return new HashSet(...$elements);
    }

    /**
     * @phpstan-return HashSet<T>
     */
    protected function emptySet() : Set
    {
        return new HashSet();
    }
}
