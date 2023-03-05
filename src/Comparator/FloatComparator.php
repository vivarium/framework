<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

use Vivarium\Float\FloatingPoint;
use Vivarium\Float\NearlyEquals;

/** @template-implements Comparator<float> */
final class FloatComparator implements Comparator
{
    private NearlyEquals $nearlyEquals;

    public function __construct(float $epsilon = FloatingPoint::EPSILON)
    {
        $this->nearlyEquals = new NearlyEquals($epsilon);
    }

    /**
     * @param float $first
     * @param float $second
     */
    public function compare($first, $second): int
    {
        if (($this->nearlyEquals)($first, $second)) {
            return 0;
        }

        if ($first < $second) {
            return -1;
        }

        return 1;
    }

    /**
     * @param float $first
     * @param float $second
     */
    public function __invoke($first, $second): int
    {
        return $this->compare($first, $second);
    }
}
