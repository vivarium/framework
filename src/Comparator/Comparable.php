<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

/** @template T */
interface Comparable
{
    /** @param T $element */
    public function compareTo($element): int;
}
