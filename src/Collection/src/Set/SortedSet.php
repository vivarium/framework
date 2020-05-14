<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use Vivarium\Collection\Map\SortedMap;
use Vivarium\Comparator\Comparator;
use function array_fill;
use function count;

/**
 * @template T
 * @template-extends MapBasedSet<T>
 */
final class SortedSet extends MapBasedSet
{
    /** @phpstan-var Comparator<T>  */
    private Comparator $comparator;

    /**
     * @param mixed ...$elements
     *
     * @phpstan-param Comparator<T> $comparator
     * @phpstan-param mixed ...$elements
     */
    public function __construct(Comparator $comparator, ...$elements)
    {
        parent::__construct(
            SortedMap::fromKeyValue(
                $comparator,
                $elements,
                array_fill(0, count($elements), self::PLACEHOLDER)
            )
        );

        $this->comparator = $comparator;
    }

    /**
     * @template T0
     * @phpstan-param Comparator<T0> $comparator
     * @phpstan-param T0[] $elements
     * @phpstan-return SortedSet<T0>
     */
    public static function fromArray(Comparator $comparator, array $elements) : SortedSet
    {
        return new SortedSet($comparator, ...$elements);
    }

    /**
     * @phpstan-return SortedSet<T>
     */
    protected function emptySet() : Set
    {
        return new SortedSet($this->comparator);
    }
}
