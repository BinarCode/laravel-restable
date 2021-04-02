<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Filters\MatchesCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface Restable
{
    public static function restableQuery(Builder $query): Builder;

    public static function perPage(): int;

    public static function searchables(): array;

    public static function matches(): array;

    public static function collectMatches(Request $request, Model $model): MatchesCollection;
}
