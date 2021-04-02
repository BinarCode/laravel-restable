<?php

namespace BinarCode\LaravelRestable\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchableCollection extends Collection
{
    public function mapIntoFilter(Model $model): self
    {
        return $this->map(function($column, $key) use ($model) {
            $filter = $column instanceof SearchableFilter
                ? $column
                : SearchableFilter::make()->setColumn(
                    $model->qualifyColumn(is_numeric($key) ? $column : $key)
                );


            return $filter->setColumn(
                $filter->column ?? $model->qualifyColumn(is_numeric($key) ? $column : $key)
            );
        });
    }

    public function apply(Request $request, Builder $builder, $value): self
    {
        return $this->each(fn(SearchableFilter $filter) => $filter->apply($request, $builder, $value));
    }
}
