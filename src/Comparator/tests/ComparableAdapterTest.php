<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator\Test;

use PHPUnit\Framework\TestCase;
use Vivarium\Comparator\ComparableAdapter;
use Vivarium\Comparator\IntegerComparator;

/**
 * @coversDefaultClass \Vivarium\Comparator\ComparableAdapter
 */
final class ComparableAdapterTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::compareTo()
     */
    public function testCompare() : void
    {
        $adapter = new ComparableAdapter(1, new IntegerComparator());

        static::assertEquals(-1, $adapter->compareTo(2));
    }
}
