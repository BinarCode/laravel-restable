<?php

namespace BinarCode\LaravelRestable;

final class Types
{
    public const DEFAULT_PER_PAGE = 15;
    public const DEFAULT_RELATABLE_PER_PAGE = 15;

    public const MATCH_TEXT = 'text';
    public const MATCH_BOOL = 'bool';
    public const MATCH_INTEGER = 'integer';
    public const MATCH_DATETIME = 'datetime';
    public const MATCH_DATETIME_INTERVAL = 'datetimeinterval';
    public const MATCH_ARRAY = 'array';
}
