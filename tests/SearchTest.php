<?php

namespace BinarCode\LaravelRestable\Tests;

use BinarCode\LaravelRestable\Tests\Fixtures\Dream;
use Illuminate\Http\Request;

class SearchTest extends TestCase
{
    public function test_can_search_declared_attributes(): void
    {
        Dream::factory(10)->create();

        Dream::factory()
            ->state([
                'dream' => 'Be Happy :)',
            ])
            ->create();

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            'search' => 'Be Happy',
        ]));

        Dream::$search = [
            'dream',
        ];

        $pagination = Dream::search($request)->paginate();

        $this->assertCount(1, $pagination->items());
    }
}
