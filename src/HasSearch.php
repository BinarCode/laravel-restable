<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Filters\SearchableCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasSearch
{
    public static function searchables(): array
    {
        return empty(static::$search)
            ? [(new static)->getQualifiedKeyName()]
            : static::$search;
    }

    public static function collectSearch(Request $request, Model $model): SearchableCollection
    {
        return SearchableCollection::make(static::searchables())
            ->mapIntoFilter($model);
    }
}
