<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Comparison;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Equality\EqualsBuilder;

use function sprintf;

/**
 * @template T
 * @template-implements Assertion<T>
 * @psalm-immutable
 */
final class IsEqualsTo implements Assertion
{
    /** @var T */
    private $compare;

    /** @param T $compare */
    public function __construct($compare)
    {
        $this->compare = $compare;
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert =T $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected value to be equals to %2$s. Got %s',
                (new TypeToString())($value),
                (new TypeToString())($this->compare),
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true =T $value
     */
    public function __invoke($value): bool
    {
        return (new EqualsBuilder())
            ->append($value, $this->compare)
            ->isEquals();
    }
}
