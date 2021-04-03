<?php

namespace BinarCode\LaravelRestable;

use BinarCode\LaravelRestable\Filters\MatchesCollection;
use BinarCode\LaravelRestable\Filters\SearchableCollection;
use BinarCode\LaravelRestable\Filters\SortCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface Restable
{
    public static function restableQuery(Builder $query): Builder;

    public static function perPage(): int;

    public static function sorts(): array;

    public static function matches(): array;

    public static function searchables(): array;

    public static function collectSorts(Request $request, Model $model): SortCollection;

    public static function collectMatches(Request $request, Model $model): MatchesCollection;

    public static function collectSearch(Request $request, Model $model): SearchableCollection;
}
