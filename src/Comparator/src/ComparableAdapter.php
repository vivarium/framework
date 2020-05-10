<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

/**
 * @template T
 * @template-implements Comparable<T>
 */
final class ComparableAdapter implements Comparable
{
    /**
     * @var mixed
     * @phpstan-var T
     */
    private $element;

    /** @phpstan-var Comparator<T>  */
    private Comparator $comparator;

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     * @phpstan-param Comparator<T> $comparator
     */
    public function __construct($element, Comparator $comparator)
    {
        $this->element    = $element;
        $this->comparator = $comparator;
    }

    /**
     * @param mixed $object
     *
     * @phpstan-param T $object
     */
    public function compareTo($object) : int
    {
        return $this->comparator->compare($this->element, $object);
    }
}
