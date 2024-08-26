<?php

namespace Vivarium\Check\Exception;

use RuntimeException;

use function sprintf;

final class TooFewArguments extends RuntimeException
{
    public function __construct(int $expected, int $actual)
    {
        parent::__construct(
            sprintf(
                'Too few arguments provided. Expected %s, got %s',
                $expected,
                $actual
            )
        );
    }
}
