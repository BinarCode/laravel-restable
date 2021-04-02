<?php

namespace BinarCode\LaravelRestable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Trait HasRestable
 *
 * @mixin Restable
 *
 * @package BinarCode\LaravelRestable
 */
trait HasRestable
{
    use HasMatchers;

    public static function restableQuery(Builder $query): Builder
    {
        return $query;
    }

    public static function search(Request $request): Builder
    {
        return Search::apply($request, static::class);
    }

    public static function searchables(): array
    {
        return empty(static::$search)
            ? [(new static)->getKeyName()]
            : static::$search;
    }

    public static function perPage(): int
    {
        return (int) property_exists(static::class, 'defaultPerPage')
            ? static::$defaultPerPage
            : 15;
    }
}
