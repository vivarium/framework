<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Hierarchy;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsInterface;

use function class_implements;
use function in_array;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<class-string>
 * @psalm-immutable
 */
final class ImplementsInterface implements Assertion
{
    /** @var class-string<T> */
    private string $interface;

    /** @param class-string<T> $interface */
    public function __construct(string $interface)
    {
        (new IsInterface())->assert($interface);

        $this->interface = $interface;
    }

    /**
     * @param class-string $value
     *
     * @psalm-assert class-string<T> $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected class %s to implements %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->interface),
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param class-string $value
     *
     * @psalm-assert-if-true class-string<T> $value
     */
    public function __invoke($value): bool
    {
        (new IsClass())->assert($value);

        $interfaces = class_implements($value);

        return $interfaces === false ?
            $interfaces : in_array($this->interface, $interfaces, true);
    }
}
