<?php

namespace BinarCode\LaravelRestable\Filters;

use BinarCode\LaravelRestable\Types;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchFilter extends Filter
{
    public static $uriKey = 'matches';

    public bool $negation = false;

    private ?Closure $resolver = null;

    public const TYPE = 'matchable';

    public string $matchType = 'text';

    public function apply(Request $request, Builder $query, $value): Builder
    {
        if ($this->resolver instanceof Closure) {
            return call_user_func($this->resolver, $request, $query, $value);
        }

        $field = $this->column;

        if ($value === 'null') {
            if ($this->negation) {
                $query->whereNotNull($field);
            } else {
                $query->whereNull($field);
            }
        } else {
            switch ($this->getMatchType()) {
                case Types::MATCH_TEXT:
                case 'string':
                    if ($this->negation) {
                        $query->where($field, $this->getNotLikeOperator(), $this->getNotLikeValue($value));
                    } else {
                        $query->where($field, $this->getLikeOperator(), $this->getLikeValue($value));
                    }
                    break;
                case Types::MATCH_BOOL:
                case 'boolean':
                    if ($value === 'false') {
                        $query->where(function ($query) use ($field) {
                            if ($this->negation) {
                                return $query->where($field, true);
                            }

                            return $query->where($field, '=', false)->orWhereNull($field);
                        });
                        break;
                    }
                    $query->where($field, $this->negation ? '!=' : '=', true);
                    break;
                case Types::MATCH_INTEGER:
                case 'number':
                case 'int':
                    $query->where($field, $this->negation ? '!=' : '=', (int) $value);
                    break;
                case Types::MATCH_DATETIME:
                    $query->whereDate($field, $this->negation ? '!=' : '=', $value);
                    break;
                case Types::MATCH_DATETIME_INTERVAL:
                    if ($this->negation) {
                        $query->whereNotBetween($field, explode(',', $value));
                    } else {
                        $query->whereBetween($field, explode(',', $value));
                    }
                    break;
                case Types::MATCH_ARRAY:
                    $value = explode(',', $value);

                    if ($this->negation) {
                        $query->whereNotIn($field, $value);
                    } else {
                        $query->whereIn($field, $value);
                    }
                    break;
            }
        }

        return $query;
    }

    public function negate(): self
    {
        $this->negation = true;

        return $this;
    }

    public function syncNegation(): self
    {
        if (Str::startsWith($this->column, '-')) {
            $this->negate();

            $this->column = Str::after($this->column, '-');

            return $this;
        }

        return $this;
    }

    public function usingClosure(Closure $closure): self
    {
        $this->resolver = $closure;

        return $this;
    }

    public function getMatchType(): string
    {
        return $this->matchType;
    }

    public function setMatchType(string $type): Filter
    {
        $this->matchType = $type;

        return $this;
    }
}
