<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Filters\MatchesCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasMatchers
{
    public static function matches(): array
    {
        return empty(static::$match)
            ? [static::newModel()->getKeyName()]
            : static::$match;
    }

    public static function collectMatches(Request $request, Model $model): MatchesCollection
    {
        return MatchesCollection::make(static::matches())
            ->normalize()
            ->authorized($request)
            ->inQuery($request)
            ->hydrateDefinition($request, $model);
    }
}
