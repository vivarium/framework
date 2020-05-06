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
use stdClass;
use Vivarium\Type\Clazz;
use Vivarium\Type\Type;

/**
 * @coversDefaultClass \Vivarium\Type\Clazz
 */
final class ClazzTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::accept()
     */
    public function testAccept() : void
    {
        $class1 = new Clazz(Iterator::class);
        $class2 = new Clazz(ArrayIterator::class);
        $class3 = new Clazz(stdClass::class);
        $type   = $this->createMock(Type::class);

        static::assertFalse($class1->accept($class3));
        static::assertFalse($class1->accept($type));
        static::assertTrue($class1->accept($class2));
    }

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
