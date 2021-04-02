<?php

namespace BinarCode\LaravelRestable\Filters;

use BinarCode\LaravelRestable\Filters\Concerns\AuthorizedToUse;
use BinarCode\LaravelRestable\Filters\Concerns\HasMode;
use BinarCode\LaravelRestable\Maker;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter
{
    use Maker;
    use HasMode;
    use AuthorizedToUse;

    public string $type;

    public ?Model $model;

    public string $column;

    public Closure $canSeeCallback;

    public function __construct($type = 'value')
    {
        $this->setType($type);

        if ($this instanceof MatchFilter) {
            $this->type = MatchFilter::TYPE;
        }

        static::booted();
    }

    protected static function booted()
    {
        //
    }

    abstract public function apply(Request $request, Builder $query, $value): Builder;

    public function setColumn(string $column): self
    {
        $this->column = $column;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function key(): string
    {
        return static::class;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQueryKey(): string
    {
        return Str::after($this->getColumn(), '.');
    }
}
