<?php

namespace BinarCode\LaravelRestable\Filters;

use BinarCode\LaravelRestable\Restable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use RuntimeException;

class SortCollection extends Collection
{
    public function __construct($items = [])
    {
        $unified = [];

        foreach ($items as $key => $item) {
            $queryKey = is_numeric($key) ? $item : $key;
            $definition = $item instanceof Filter
                ? $item
                : SortableFilter::make();

            if ($queryKey instanceof SortableFilter) {
                $unified[] = $queryKey;

                continue;
            }

            $definition->setColumn(
                $definition->column ?? $queryKey
            );

            $unified[] = $definition;
        }

        parent::__construct($unified);
    }

    public function hydrateModel(Model $model): self
    {
        return $this->each(fn (Filter $filter) => $filter->setModel($model));
    }

    public function inModel(Request $request, Model $model): self
    {
        /**
         * @var Restable $model
         */
        $collection = SortCollection::make($model::sorts());

        return $this->filter(fn (SortableFilter $filter) => $collection->contains('column', '=', $filter->column));
    }

    public function authorized(Request $request): self
    {
        return $this->filter(fn (SortableFilter $filter) => $filter->authorizedToUse($request));
    }

    public function hydrateDefinition(Model $model): self
    {
        /**
         * @var Restable $model
         */
        return $this->map(function (SortableFilter $filter) use ($model) {
            if (! array_key_exists($filter->column, $model::sorts())) {
                return $filter;
            }

            $definition = Arr::get($model::sorts(), $filter->getColumn());

            if ($definition instanceof SortableFilter) {
                return $definition->syncDirection($filter->direction());
            }

            throw new RuntimeException("Invalid argument to {$filter->column} sort in repository.");
        });
    }

    public function normalize(): self
    {
        return $this->each(fn (SortableFilter $filter) => $filter->syncDirection());
    }

    public function apply(Request $request, Builder $builder): self
    {
        return $this->each(function (SortableFilter $filter) use ($request, $builder) {
            $filter->apply($request, $builder, $filter->direction());
        });
    }
}
