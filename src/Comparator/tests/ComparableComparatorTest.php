<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator\Test;

use PHPUnit\Framework\TestCase;
use Vivarium\Comparator\Comparable;
use Vivarium\Comparator\ComparableComparator;

/**
 * @coversDefaultClass \Vivarium\Comparator\ComparableComparator
 */
final class ComparableComparatorTest extends TestCase
{
    /**
     * @covers ::compare()
     * @covers ::__invoke()
     */
    public function testCompare() : void
    {
        $comparable1 = $this->createMock(Comparable::class);
        $comparable2 = $this->createMock(Comparable::class);
        $comparable2
            ->expects(static::exactly(2))
            ->method('compareTo')
            ->with($comparable1)
            ->willReturn(1);

        $comparator = new ComparableComparator();
        $comparator->compare($comparable2, $comparable1);
        $comparator($comparable2, $comparable1);
    }
}
