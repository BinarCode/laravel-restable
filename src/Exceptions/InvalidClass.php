<?php

namespace BinarCode\LaravelRestable\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class InvalidClass extends Exception
{
    #[Pure]
 public static function shouldBe(string $expected): self
 {
     return new static("Class should be an instance of {$expected}");
 }

    #[Pure]
 public static function shouldUse(string $trait): self
 {
     return new static("Class should use trait {$trait}");
 }
}
