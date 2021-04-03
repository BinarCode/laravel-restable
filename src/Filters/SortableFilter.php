<?php

namespace BinarCode\LaravelRestable\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SortableFilter extends Filter
{
    public const TYPE = 'sortable';

    public string $direction = 'asc';

    public function apply(Request $request, Builder $query, $value): Builder
    {
        if ($this->resolver instanceof Closure) {
            return call_user_func($this->resolver, $request, $query, $value);
        }

        return $query->orderBy($this->column, $value);
    }

    public function asc(): self
    {
        $this->direction = 'asc';

        return $this;
    }

    public function desc(): self
    {
        $this->direction = 'desc';

        return $this;
    }

    public function direction(): string
    {
        return $this->direction;
    }

    public function syncDirection(string $direction = null): self
    {
        if (! is_null($direction) && in_array($direction, ['asc', 'desc'])) {
            $this->direction = $direction;

            return $this;
        }

        if (Str::startsWith($this->column, '-')) {
            $this->desc();

            $this->column = Str::after($this->column, '-');

            return $this;
        }

        if (Str::startsWith($this->column, '+')) {
            $this->asc();

            $this->column = Str::after($this->column, '+');

            return $this;
        }

        return $this->asc();
    }
}
