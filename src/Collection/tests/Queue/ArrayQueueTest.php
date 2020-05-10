<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Queue;

use DomainException;
use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Queue\ArrayQueue;

/**
 * @coversDefaultClass \Vivarium\Collection\Queue\ArrayQueue
 */
final class ArrayQueueTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::add()
     * @covers ::enqueue()
     * @covers ::count()
     * @covers ::peek()
     * @covers ::toArray()
     */
    public function testEnqueue() : void
    {
        $queue1 = new ArrayQueue(1, 2, 3);
        $queue1->enqueue(4);

        /** @psalm-var ArrayQueue<int> $queue2 */
        $queue2 = new ArrayQueue(1, 2, 3);
        $queue2->add(4);

        static::assertCount(4, $queue1);
        static::assertEquals(1, $queue1->peek());
        static::assertEquals($queue1->toArray(), $queue2->toArray());
    }

    /**
     * @covers ::dequeue()
     * @covers ::isEmpty()
     * @covers ::peek()
     * @covers ::fromArray()
     */
    public function testDequeue() : void
    {
        $elements = ['a', 'b', 'c', 'd'];
        $queue    = ArrayQueue::fromArray($elements);

        $index = 0;
        while (! $queue->isEmpty()) {
            $element = $queue->peek();
            $queue->dequeue();

            static::assertEquals($elements[$index], $element);
            ++$index;
        }

        static::assertTrue($queue->isEmpty());
    }

    /**
     * @covers ::remove()
     * @covers ::toArray()
     * @covers ::fromArray()
     */
    public function testRemove() : void
    {
        $elements = [1, 2, 3, 4, 5, 6];
        $expected = [5, 6];

        $queue = ArrayQueue::fromArray($elements);
        $queue->remove(4);
        $queue->remove(2);

        static::assertEquals($expected, $queue->toArray());
    }

    /**
     * @covers ::dequeue()
     */
    public function testDequeueOnEmpty() : void
    {
        static::expectException(DomainException::class);
        static::expectExceptionMessage('Cannot dequeue from an empty queue.');

        $queue = new ArrayQueue();
        $queue->dequeue();
    }

    /**
     * @covers ::peek()
     */
    public function testPeekOnEmpty() : void
    {
        static::expectException(DomainException::class);
        static::expectExceptionMessage('Cannot peek from an empty queue.');

        $queue = new ArrayQueue();
        $queue->peek();
    }

    /**
     * @covers ::contains()
     */
    public function testContains() : void
    {
        /** @psalm-var ArrayQueue<int> $queue */
        $queue = new ArrayQueue(1, 2, 3, 4, 5);

        static::assertTrue($queue->contains(3));
        static::assertFalse($queue->contains(42));
    }

    /**
     * @covers ::clear()
     */
    public function testClear() : void
    {
        $queue = new ArrayQueue(1, 2, 3);
        $queue->clear();

        static::assertCount(0, $queue);
    }

    /**
     * @covers ::getIterator()
     */
    public function testGetIterator() : void
    {
        $queue = new ArrayQueue(1, 2, 3);
        $order = [1, 2, 3];

        $index    = 0;
        $iterator = $queue->getIterator();
        while ($iterator->valid()) {
            static::assertEquals($order[$index], $iterator->current());
            $iterator->next();
            ++$index;
        }
    }
}
