<?php

namespace BinarCode\LaravelRestable\Tests\Database\Factories;

use BinarCode\LaravelRestable\Tests\Fixtures\Dream;
use Illuminate\Database\Eloquent\Factories\Factory;

class DreamFactory extends Factory
{
    protected $model = Dream::class;

    public function definition()
    {
        return [
            'dream' => $this->faker->word,
        ];
    }
}
