<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Vivarium\Type\Tuple;
use Vivarium\Type\Type;
use function count;

/**
 * @coversDefaultClass \Vivarium\Type\Tuple
 */
final class TupleTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::count()
     */
    public function testCount() : void
    {
        $type  = $this->createMock(Type::class);
        $tuple = new Tuple($type, $type, $type);

        static::assertCount(3, $tuple);
    }

    /**
     * @covers ::getIterator()
     */
    public function testIterator() : void
    {
        $type1 = $this->createMock(Type::class);
        $type2 = $this->createMock(Type::class);
        $type3 = $this->createMock(Type::class);

        $tuple = new Tuple($type3, $type1, $type2);
        $iter  = $tuple->getIterator();
        $iter->rewind();

        $expected = [$type3, $type1, $type2];
        for ($i=0; $i < count($expected); $i++) {
            static::assertSame($expected[$i], $iter->current());
            $iter->next();
        }
    }

    /**
     * @covers ::nth()
     */
    public function testNth() : void
    {
        static::expectException(OutOfBoundsException::class);
        static::expectExceptionMessage('Index out of bound. Count: 3, Index: 3');

        $type1 = $this->createMock(Type::class);
        $type2 = $this->createMock(Type::class);
        $type3 = $this->createMock(Type::class);

        $tuple = new Tuple($type1, $type2, $type3);

        static::assertSame($type1, $tuple->nth(0));
        static::assertSame($type2, $tuple->nth(1));
        static::assertSame($type3, $tuple->nth(2));
        static::assertSame($type1, $tuple->nth(3));
    }

    /**
     * @covers ::accept()
     */
    public function testAccept() : void
    {
        $type1 = $this->createMock(Type::class);
        $type2 = $this->createMock(Type::class);
        $type3 = $this->createMock(Type::class);

        $type1
            ->expects(static::exactly(2))
            ->method('accept')
            ->withConsecutive([$type1], [$type1])
            ->willReturnOnConsecutiveCalls(true, true);

        $type3
            ->expects(static::exactly(2))
            ->method('accept')
            ->withConsecutive([$type2], [$type3])
            ->willReturnOnConsecutiveCalls(false, true);

        $tuple1 = new Tuple($type1, $type2);
        $tuple2 = new Tuple($type3);
        $tuple3 = new Tuple($type1, $type3);
        $tuple4 = new Tuple($type1, $type3);

        static::assertFalse($tuple1->accept($tuple2));
        static::assertFalse($tuple3->accept($tuple1));
        static::assertTrue($tuple4->accept($tuple3));
    }
}
