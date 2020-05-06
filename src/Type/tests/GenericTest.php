<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Type\Clazz;
use Vivarium\Type\Generic;
use Vivarium\Type\Native;
use Vivarium\Type\Test\Stub\Foo;
use Vivarium\Type\Tuple;

/**
 * @coversDefaultClass \Vivarium\Type\Generic
 */
final class GenericTest extends TestCase
{
    /**
     * @covers ::acceptVar()
     */
    public function testAccept() : void
    {
        $class = new Clazz(Foo::class);
        $tuple = new Tuple(
            Native::integer(),
            Native::string(),
            new Clazz(stdClass::class)
        );

        $generic = new Generic($class, $tuple);

        static::assertTrue($generic->acceptVar(new Foo()));
        static::assertFalse($generic->acceptVar(new stdClass()));
    }
}
