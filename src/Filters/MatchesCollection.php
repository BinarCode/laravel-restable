<?php

namespace BinarCode\LaravelRestable\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MatchesCollection extends Collection
{
    public function __construct($items = [])
    {
        $unified = [];

        foreach ($items as $column => $matchType) {
            $definition = $matchType instanceof MatchFilter
                ? $matchType
                : tap(MatchFilter::make(), fn (MatchFilter $filter) => is_string($matchType) ? $filter->setMatchType($matchType) : '');

            if ($matchType instanceof Closure) {
                $definition->resolveUsing($matchType);
            }

            $definition->setColumn(
                $definition->column ?? $column
            );

            $definition->setMatchType(
                $definition->matchType ?? (is_string($matchType) ? $matchType : 'int')
            );

            $unified[] = $definition;
        }

        parent::__construct($unified);
    }

    public function hydrateModel(Model $model): self
    {
        return $this->each(fn (Filter $filter) => $filter->setModel($model));
    }

    public function inQuery(Request $request): self
    {
        return $this->filter(fn (MatchFilter $filter) => ($request->has("-{$filter->getQueryKey()}") || $request->has($filter->getQueryKey())));
    }

    public function authorized(Request $request): self
    {
        return $this->filter(fn (MatchFilter $filter) => $filter->authorizedToUse($request));
    }

    public function hydrateDefinition(Request $request, Model $model): MatchesCollection
    {
        return $this->each(function (MatchFilter $filter) use ($model, $request) {
            if ($request->has('-' . $filter->getQueryKey())) {
                $filter->negate();
            }

            return $filter->setColumn($model->qualifyColumn($filter->getColumn()));
        });
    }

    public function normalize(): self
    {
        return $this;
    }

    public function apply(Request $request, Builder $builder): self
    {
        return $this->each(function (MatchFilter $filter) use ($request, $builder) {
            $queryValue = $request->input($filter->negation ? '-' . $filter->getQueryKey() : $filter->getQueryKey());

            $filter->apply($request, $builder, $queryValue);
        });
    }
}
