<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion;

use Vivarium\Assertion\Exception\AssertionFailed;

/** @template-covariant T */
interface Assertion
{
    /**
     * @throws AssertionFailed
     *
     * @psalm-assert T $value
     */
    public function assert(mixed $value, string $message = ''): void;

    /** @psalm-assert-if-true T $value */
    public function __invoke(mixed $value): bool;
}
