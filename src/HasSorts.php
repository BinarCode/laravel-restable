<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Filters\SortCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasSorts
{
    public static function sorts(): array
    {
        return empty(static::$sort)
            ? [(new static)->getQualifiedKeyName()]
            : static::$sort;
    }

    public static function collectSorts(Request $request, Model $model): SortCollection
    {
        return SortCollection::make(explode(',', $request->input('sort', '')))
            ->normalize()
            ->hydrateDefinition($model)
            ->authorized($request)
            ->inModel($request, $model)
            ->hydrateModel($model);
    }
}
