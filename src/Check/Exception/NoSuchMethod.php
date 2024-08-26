<?php

namespace Vivarium\Check\Exception;

use RuntimeException;

use function sprintf;
use function ucfirst;

final class NoSuchMethod extends RuntimeException
{
    public function __construct(string $method, string $class)
    {
        parent::__construct(
            sprintf(
                'No such method %s. Missing class %s.',
                $method,
                $class
            )
        );
    }
}
