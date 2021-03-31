<?php

namespace BinarCode\LaravelRestable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Restable
{
    public static int $defaultPerPage = 15;

    public static function restableQuery(Builder $query): Builder
    {
        return $query;
    }

    public static function search(Request $request): Search
    {
        return Search::search($request, static::class);
    }
}
