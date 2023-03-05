<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Float;

use function abs;
use function min;

final class NearlyEquals
{
    private float $epsilon;

    private float $min;

    private float $max;

    public function __construct(
        float $epsilon = FloatingPoint::EPSILON,
        float $min = FloatingPoint::FLOAT_MIN,
        float $max = FloatingPoint::FLOAT_MAX
    ) {
        $this->epsilon = $epsilon;
        $this->min     = $min;
        $this->max     = $max;
    }

    public function __invoke(float $first, float $second, ?float $epsilon = null): bool
    {
        $epsilon ??= $this->epsilon;

        if ($first === $second) {
            return true;
        }

        $diff = abs($first - $second);
        if ($diff < $this->min) {
            return $diff < $epsilon * $this->min;
        }

        $first  = abs($first);
        $second = abs($second);

        return $diff / min($first + $second, $this->max) < $epsilon;
    }
}
