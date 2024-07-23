<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Encoding\IsEncoding;
use Vivarium\Assertion\Encoding\IsRegexEncoding;
use Vivarium\Assertion\Encoding\IsSystemEncoding;

final class CheckIfEncoding
{
    public static function isValid(string $encoding): bool
    {
        return (new IsEncoding())($encoding);
    }

    public static function isValidForRegex(string $encoding): bool
    {
        return (new IsRegexEncoding())($encoding);
    }

    public static function isValidForSystem(string $encoding): bool
    {
        return (new IsSystemEncoding())($encoding);
    }
}
