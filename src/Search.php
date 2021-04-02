<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Exceptions\InvalidClass;
use BinarCode\LaravelRestable\Filters\SearchableCollection;
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

    public static function apply(Request $request, string $modelClass): Builder
    {
        if (! is_subclass_of($modelClass, Model::class)) {
            throw InvalidClass::shouldBe(Model::class);
        }

        return static::query($request, $modelClass::query());
    }

    public static function query(Request $request, Builder $builder): Builder
    {
        if (! in_array(Restable::class, class_uses_recursive($model = $builder->getModel()))) {
            throw InvalidClass::shouldUse(Restable::class);
        }

        return $model::restableQuery(
            (new static($request, $builder, $builder->getModel()))->search($builder)
        );
    }

    public function paginate(): LengthAwarePaginator
    {
        return $this->builder->paginate($this->getPerPage());
    }

    public function search(Builder $builder): Builder
    {
        if (empty($search = $this->request->input('search'))) {
            return $builder;
        }


        return $builder->where(function (Builder $query) use ($search) {
            SearchableCollection::make($this->model::searchables())
                ->mapIntoFilter($this->model)
                ->apply($this->request, $query, $search);
        });
    }

    public function getPerPage(): int
    {
        return (int)($this->request->input('perPage') ?? ($this->model)::defaultPerPage());
    }
}
