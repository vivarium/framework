<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test;

use ArrayIterator;
use Iterator;
use PHPUnit\Framework\TestCase;
use Vivarium\Type\Clazz;

/**
 * @coversDefaultClass \Vivarium\Type\Clazz
 */
final class ClazzTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::acceptVar()
     */
    public function testAcceptVar() : void
    {
        $class = new Clazz(Iterator::class);
        $iter  = new ArrayIterator([]);

        static::assertTrue($class->acceptVar($iter));
        static::assertFalse($class->acceptVar(ArrayIterator::class));
        static::assertFalse($class->acceptVar(42));
    }
}
