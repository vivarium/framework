<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

use Vivarium\Assertion\Type\IsString;
use function strcmp;

/**
 * @template-implements Comparator<string>
 */
final class StringComparator implements Comparator
{
    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param string $first
     * @phpstan-param string $second
     */
    public function compare($first, $second) : int
    {
        (new IsString())->assert($first);
        (new IsString())->assert($second);

        return strcmp($first, $second);
    }

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param string $first
     * @phpstan-param string $second
     */
    public function __invoke($first, $second) : int
    {
        return $this->compare($first, $second);
    }
}
