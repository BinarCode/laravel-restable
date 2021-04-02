<?php

namespace BinarCode\LaravelRestable\Filters;

use BinarCode\LaravelRestable\Maker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    use Maker;

    public string $column;

    abstract public function apply(Request $request, Builder $query, $value): Builder;

    public function setColumn(string $column): self
    {
        $this->column = $column;

        return $this;
    }
}
