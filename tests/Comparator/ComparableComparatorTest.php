<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Comparator;

use PHPUnit\Framework\TestCase;
use Vivarium\Comparator\Comparable;
use Vivarium\Comparator\ComparableComparator;

/**
 * @coversDefaultClass \Vivarium\Comparator\ComparableComparator
 */
class ComparableComparatorTest extends TestCase
{
    /**
     * @covers ::compare()
     * @covers ::__invoke()
     */
    public function testCompare(): void
    {
        $comparable1 = $this->createMock(Comparable::class);
        $comparable1
            ->expects(static::exactly(2))
            ->method('compareTo')
            ->willReturn(1);

        $comparable2 = $this->createMock(Comparable::class);

        $comparator = new ComparableComparator();
        static::assertSame(1, $comparator->compare($comparable1, $comparable2));
        static::assertSame(1, $comparator($comparable1, $comparable2));
    }
}
