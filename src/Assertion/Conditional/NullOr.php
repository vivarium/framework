<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Conditional;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;

/**
 * @template T as mixed
 * @template-implements Assertion<T>
 */
final class NullOr implements Assertion
{
    /** @var Assertion<T> */
    private Assertion $assertion;

    /** @param Assertion<T> $assertion */
    public function __construct(Assertion $assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * @param T $value
     *
     * @throws InvalidArgumentException
     *
     * @psalm-assert T|null $value
     */
    public function assert($value, string $message = ''): void
    {
        if ($value === null) {
            return;
        }

        $this->assertion->assert($value, $message);
    }

    /**
     * @param T $value
     *
     * @psalm-assert-if-true T|null $value
     */
    public function __invoke($value): bool
    {
        return $value === null || ($this->assertion)($value);
    }
}
