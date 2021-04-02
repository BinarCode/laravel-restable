<?php

namespace BinarCode\LaravelRestable\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchableFilter extends Filter
{
    public function apply(Request $request, Builder $query, $value): Builder
    {
        $connectionType = $query->getModel()->getConnection()->getDriverName();

        $likeOperator = $connectionType === 'pgsql' ? 'ilike' : 'like';

        return $query->orWhere($this->column, $likeOperator, '%' . $value . '%');
    }
}
