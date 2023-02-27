<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion;

use Vivarium\Assertion\Exception\AssertionFailed;

/** @template  T */
interface Assertion
{
    /**
     * @param T $value
     *
     * @throws AssertionFailed
     *
     * @psalm-mutation-free
     */
    public function assert($value, string $message = ''): void;

    /**
     * @param T $value
     *
     * @psalm-mutation-free
     */
    public function __invoke($value): bool;
}
