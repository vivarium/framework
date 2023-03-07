<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Numeric;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\Type\IsFloat;
use Vivarium\Assertion\Type\IsInteger;
use Vivarium\Assertion\Type\IsNumeric;

use function sprintf;

/**
 * @template T of int|float
 * @template-implements Assertion<T>
 */
final class IsGreaterOrEqualThan implements Assertion
{
    /** @var T */
    private $compare;

    /** @param T $compare */
    public function __construct($compare)
    {
        (new IsNumeric())->assert($compare);

        $this->compare = $compare;
    }

    /** @psalm-assert T $value */
    public function assert(mixed $value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected number to be greater or equal than %2$s. Got %s.',
                (new TypeToString())($value),
                (new TypeToString())($this->compare),
            );

            throw new AssertionFailed($message);
        }
    }

    /** @psalm-assert-if-true T $value */
    public function __invoke(mixed $value): bool
    {
        (new IsNumeric())->assert($value);

        return $value >= $this->compare;
    }
}
