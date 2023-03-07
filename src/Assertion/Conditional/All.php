<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Conditional;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;

use function array_merge;

/**
 * @template T
 * @template-implements Assertion<T>
 */
final class All implements Assertion
{
    /** @var array<Assertion<T>> */
    private array $assertions;

    /**
     * @param Assertion<T> $assertion
     * @param Assertion<T> ...$assertions
     */
    public function __construct(Assertion $assertion, Assertion ...$assertions)
    {
        $this->assertions = array_merge([$assertion], $assertions);
    }

    /** @psalm-assert T $value */
    public function assert(mixed $value, string $message = ''): void
    {
        foreach ($this->assertions as $assertion) {
            $assertion->assert($value, $message);
        }
    }

    /** @psalm-assert-if-true T $value */
    public function __invoke(mixed $value): bool
    {
        try {
            $this->assert($value);
        } catch (AssertionFailed) {
            return false;
        }

        return true;
    }
}
