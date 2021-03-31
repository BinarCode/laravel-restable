<?php

namespace Binarcode\LaravelRestable\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dream extends Model
{
    protected $table = 'dreams';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
