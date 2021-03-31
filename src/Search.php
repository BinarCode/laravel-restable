<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Exceptions\InvalidClass;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Search
{
    public function __construct(
        public Request $request,
        public Builder $builder,
        public Model $model
    ) {
    }

    public static function search(Request $request, string $modelClass): self
    {
        if (! is_subclass_of($modelClass, Model::class)) {
            throw InvalidClass::shouldBe(Model::class);
        }

        return static::query($request, $modelClass::query());
    }

    public static function query(Request $request, Builder $builder): self
    {
        if (! in_array(Restable::class, class_uses_recursive($builder->getModel()))) {
            throw InvalidClass::shouldUse(Restable::class);
        }

        return new static($request, $builder, $builder->getModel());
    }

    public function paginate(): LengthAwarePaginator
    {
        return $this->builder->paginate($this->getPerPage());
    }

    public function getPerPage(): int
    {
        return (int) ($this->request->input('perPage') ?? ($this->model)::$defaultPerPage);
    }
}
