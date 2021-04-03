<?php

namespace BinarCode\LaravelRestable\Filters\Concerns;

use Closure;

trait HasResolver
{
    protected ?Closure $resolver = null;

    public function resolveUsing(Closure $closure): self
    {
        $this->resolver = $closure;

        return $this;
    }
}
