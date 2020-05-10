<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

use Vivarium\Assertion\Type\IsInteger;

/**
 * @template-implements Comparator<int>
 */
final class IntegerComparator implements Comparator
{
    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param int $first
     * @phpstan-param int $second
     */
    public function compare($first, $second) : int
    {
        (new IsInteger())->assert($first);
        (new IsInteger())->assert($second);

        if ($first < $second) {
            return -1;
        }

        if ($first > $second) {
            return 1;
        }

        return 0;
    }

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param int $first
     * @phpstan-param int $second
     */
    public function __invoke($first, $second) : int
    {
        return $this->compare($first, $second);
    }
}
