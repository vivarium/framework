<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

/**
 * @template T
 * @template-implements Comparable<T>
 */
final class ComparableAdapter implements Comparable
{
    /** @var T */
    private $element;

    /** @var Comparator<T>  */
    private Comparator $comparator;

    /**
     * @param T             $element
     * @param Comparator<T> $comparator
     *
     * @psalm-mutation-free
     */
    public function __construct($element, Comparator $comparator)
    {
        $this->element    = $element;
        $this->comparator = $comparator;
    }

    /**
     * @param T $element
     *
     * @psalm-mutation-free
     */
    public function compareTo($element): int
    {
        return $this->comparator->compare($this->element, $element);
    }
}
