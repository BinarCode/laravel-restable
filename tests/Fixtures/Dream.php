<?php

namespace BinarCode\LaravelRestable\Tests\Fixtures;

use BinarCode\LaravelRestable\HasRestable;
use BinarCode\LaravelRestable\Restable;
use BinarCode\LaravelRestable\Tests\Database\Factories\DreamFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dream extends Model implements Restable
{
    use HasRestable;
    use HasFactory;

    protected $table = 'dreams';

    protected $fillable = [
        'dream',
    ];

    public static array $search = [
        'id',
    ];

    public static array $match = [
        'dream',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function newFactory(): Factory
    {
        return DreamFactory::new();
    }
}
