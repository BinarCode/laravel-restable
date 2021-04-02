<?php

namespace BinarCode\LaravelRestable\Exceptions;

use Exception;

class InvalidClass extends Exception
{
    public static function shouldBe(string $expected, string $actual): self
    {
        return new static("Class {$actual} should be an instance of {$expected}.");
    }

    public static function shouldUse(string $trait): self
    {
        return new static("Class should use trait {$trait}");
    }
}
