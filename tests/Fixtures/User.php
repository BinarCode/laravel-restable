<?php

namespace Binarcode\LaravelRestable\Tests\Fixtures;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    public function dreams(): HasMany
    {
        return $this->hasMany(Dream::class);
    }
}
