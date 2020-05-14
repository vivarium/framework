<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Sequence;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Collection\Sequence\ArraySequence;
use function count;
use function max;
use function sprintf;

/**
 * @coversDefaultClass \Vivarium\Collection\Sequence\ArraySequence
 */
final class ArrayListExceptionTest extends TestCase
{
    /**
     * @param array<int, int> $elements
     *
     * @covers ::getAtIndex()
     * @covers ::checkBounds()
     * @dataProvider getTestIndexOutOfBoundData
     */
    public function testGetAtIndexOutOfBound(array $elements, int $index) : void
    {
        $message = sprintf(
            'Expected number to be in half open right range [0, %s). Got %2$s.',
            max(1, count($elements)),
            $index
        );

        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage($message);

        $list = ArraySequence::fromArray($elements);
        $list->getAtIndex($index);
    }

    /**
     * @param array<int, int> $elements
     *
     * @covers ::setAtIndex()
     * @covers ::checkBounds()
     * @dataProvider getTestIndexOutOfBoundData
     */
    public function testSetAtIndexOutOfBound(array $elements, int $index) : void
    {
        if ($index === count($elements)) {
            ++$index;
        }

        $message = sprintf(
            'Expected number to be in closed range [0, %s]. Got %2$s.',
            count($elements),
            $index
        );

        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage($message);

        $list = ArraySequence::fromArray($elements);
        $list->setAtIndex($index, 42);
    }

    /**
     * @param array<int, int> $elements
     *
     * @covers ::removeAtIndex()
     * @covers ::checkBounds()
     * @dataProvider getTestIndexOutOfBoundData
     */
    public function testRemoveAtIndexOutOfBound(array $elements, int $index) : void
    {
        $message = sprintf(
            'Expected number to be in half open right range [0, %s). Got %2$s.',
            max(1, count($elements)),
            $index
        );

        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage($message);

        $list = ArraySequence::fromArray($elements);
        $list->removeAtIndex($index);
    }

    /**
     * @return array<array-key, array{0:list<int>, 1:int}>
     */
    public function getTestIndexOutOfBoundData() : array
    {
        return [
            'Empty List lower bound' =>
                [
                    [],
                    -1,
                ],
            'Empty List upper bound' =>
                [
                    [],
                    5,
                ],
            'Full list lower bound' =>
                [
                    [1, 2, 3, 4, 5],
                    -2,
                ],
            'Full list upper bound' =>
                [
                    [1, 2, 3, 4, 5],
                    5,
                ],
        ];
    }
}
