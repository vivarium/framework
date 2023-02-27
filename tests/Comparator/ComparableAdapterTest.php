<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Comparator;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Comparator\ComparableAdapter;
use Vivarium\Comparator\Comparator;

/**
 * @coversDefaultClass \Vivarium\Comparator\ComparableAdapter
 */
class ComparableAdapterTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::compareTo()
     */
    public function testCompare(): void
    {
        $first  = new stdClass();
        $second = new stdClass();

        $comparator = $this->createMock(Comparator::class);
        $comparator->expects(static::once())
                   ->method('compare')
                   ->with(static::equalTo($first), static::equalTo($second))
                   ->willReturn(1);

        $adapter = new ComparableAdapter($first, $comparator);

        static::assertSame(1, $adapter->compareTo($second));
    }
}
