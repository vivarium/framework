<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;

use function gettype;
use function is_float;
use function sprintf;

/**
 * @template-implements Assertion<mixed>
 * @psalm-immutable
 */
final class IsFloat implements Assertion
{
    /**
     * @param mixed $value
     *
     * @throws AssertionFailed
     *
     * @psalm-assert float $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected value to be float. Got %2$s.',
                (new TypeToString())($value),
                gettype($value),
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true float $value
     */
    public function __invoke($value): bool
    {
        return is_float($value);
    }
}
