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
use Vivarium\Collection\Queue\PriorityQueue;
use Vivarium\Comparator\IntegerComparator;
use Vivarium\Comparator\StringComparator;
use function usort;

/**
 * @coversDefaultClass \Vivarium\Collection\Queue\PriorityQueue
 */
final class PriorityQueueTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::enqueue()
     * @covers ::peek()
     * @covers ::count()
     * @covers ::add()
     */
    public function testEnqueue() : void
    {
        $queue = new PriorityQueue(new IntegerComparator());
        $queue->enqueue(4);
        $queue->enqueue(3);
        $queue->enqueue(3);
        $queue->enqueue(0);
        $queue->add(1);

        static::assertCount(5, $queue);
        static::assertEquals(0, $queue->peek());
    }

    /**
     * @covers ::dequeue()
     * @covers ::isEmpty()
     * @covers ::peek()
     * @covers ::fromArray()
     */
    public function testDequeue() : void
    {
        $elements = ['z', 'k', 'v', 'a', 'd'];
        $queue    = PriorityQueue::fromArray(new StringComparator(), $elements);

        usort($elements, new StringComparator());

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
     * @covers ::dequeue()
     */
    public function testDequeueOnEmpty() : void
    {
        static::expectException(DomainException::class);
        static::expectExceptionMessage('Cannot dequeue from an empty queue.');

        $queue = new PriorityQueue(new StringComparator());
        $queue->dequeue();
    }

    /**
     * @covers ::remove()
     * @covers ::toArray()
     * @covers ::fromArray()
     */
    public function testRemove() : void
    {
        $elements = [6, 5, 2, 1, 0, 3, 4];
        $expected = [5, 6];

        $queue = PriorityQueue::fromArray(new IntegerComparator(), $elements);
        $queue->remove(4);
        $queue->remove(2);

        static::assertEquals($expected, $queue->toArray());
    }

    /**
     * @covers ::clear()
     * @covers ::count()
     */
    public function testClear() : void
    {
        $queue = new PriorityQueue(new IntegerComparator(), 5, 2, 1);
        $queue->clear();

        static::assertCount(0, $queue);
    }

    /**
     * @covers ::getIterator()
     */
    public function testGetIterator() : void
    {
        $queue = new PriorityQueue(new IntegerComparator(), 3, 2, 1);
        $order = [1, 2, 3];

        $index    = 0;
        $iterator = $queue->getIterator();
        while ($iterator->valid()) {
            static::assertEquals($order[$index], $iterator->current());
            $iterator->next();
            ++$index;
        }
    }

    /**
     * @covers ::toArray()
     */
    public function testToArray() : void
    {
        $queue = new PriorityQueue(new IntegerComparator(), 42, 6, 3, 23, 1);

        $expected = [1, 3, 6, 23, 42];

        static::assertEquals($expected, $queue->toArray());
    }

    /**
     * @covers ::contains()
     */
    public function testContains() : void
    {
        /** @psalm-var PriorityQueue<int> $queue */
        $queue = new PriorityQueue(new IntegerComparator(), 3, 2, 4, 1);

        static::assertTrue($queue->contains(3));
        static::assertFalse($queue->contains(42));
    }
}
