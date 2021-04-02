<?php

namespace BinarCode\LaravelRestable\Filters\Concerns;

use Closure;
use Illuminate\Http\Request;

trait AuthorizedToUse
{
    /**
     * The callback used to authorize.
     *
     * @var Closure|null
     */
    public ?Closure $useCallback = null;

    /**
     * Determine if the filter or action should be available for the given request.
     *
     * @param Request $request
     * @return bool
     */
    public function authorizedToUse(Request $request): bool
    {
        return $this->useCallback ? call_user_func($this->useCallback, $request) : true;
    }

    /**
     * Set the callback to be run to authorize viewing the filter or action.
     *
     * @param Closure $callback
     * @return self
     */
    public function canUse(Closure $callback): self
    {
        $this->useCallback = $callback;

        return $this;
    }
}
