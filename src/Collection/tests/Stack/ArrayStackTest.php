<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Stack;

use DomainException;
use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Stack\ArrayStack;

/**
 * @coversDefaultClass \Vivarium\Collection\Stack\ArrayStack
 */
final class ArrayStackTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::add()
     * @covers ::push()
     * @covers ::count()
     * @covers ::peek()
     * @covers ::toArray()
     */
    public function testPush() : void
    {
        $stack1 = new ArrayStack(1, 2, 3);
        $stack1->push(4);

        $stack2 = new ArrayStack(1, 2, 3);
        $stack2->add(4);

        static::assertCount(4, $stack1);
        static::assertEquals(4, $stack1->peek());
        static::assertEquals($stack1->toArray(), $stack2->toArray());
    }

    /**
     * @covers ::pop()
     * @covers ::isEmpty()
     * @covers ::peek()
     * @covers ::fromArray()
     */
    public function testPop() : void
    {
        $elements = ['a', 'b', 'c', 'd'];
        $stack    = ArrayStack::fromArray($elements);

        $index = 3;
        while (! $stack->isEmpty()) {
            $element = $stack->pop();

            static::assertEquals($elements[$index], $element);
            --$index;
        }

        static::assertTrue($stack->isEmpty());
    }

    /**
     * @covers ::remove()
     * @covers ::toArray()
     * @covers ::fromArray()
     */
    public function testRemove() : void
    {
        $elements = [1, 2, 3, 4, 5, 6];
        $expected = [1];

        $stack = ArrayStack::fromArray($elements);
        $stack->remove(4);
        $stack->remove(2);

        static::assertEquals($expected, $stack->toArray());
    }

    /**
     * @covers ::pop()
     */
    public function testPopOnEmpty() : void
    {
        static::expectException(DomainException::class);
        static::expectExceptionMessage('Cannot pop from an empty stack.');

        $stack = new ArrayStack();
        $stack->pop();
    }

    /**
     * @covers ::peek()
     */
    public function testPeekOnEmpty() : void
    {
        static::expectException(DomainException::class);
        static::expectExceptionMessage('Cannot peek from an empty stack.');

        $stack = new ArrayStack();
        $stack->peek();
    }

    /**
     * @covers ::contains()
     */
    public function testContains() : void
    {
        $stack = new ArrayStack(1, 2, 3, 4, 5);

        static::assertTrue($stack->contains(3));
        static::assertFalse($stack->contains(42));
    }

    /**
     * @covers ::clear()
     */
    public function testClear() : void
    {
        $stack = new ArrayStack(1, 2, 3);
        $stack->clear();

        static::assertCount(0, $stack);
    }

    /**
     * @covers ::getIterator()
     */
    public function testGetIterator() : void
    {
        $stack = new ArrayStack(1, 2, 3);
        $order = [3, 2, 1];

        $index    = 0;
        $iterator = $stack->getIterator();
        while ($iterator->valid()) {
            static::assertEquals($order[$index], $iterator->current());
            $iterator->next();
            ++$index;
        }
    }
}
