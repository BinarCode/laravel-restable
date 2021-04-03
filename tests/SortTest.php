<?php

namespace BinarCode\LaravelRestable\Tests;

use BinarCode\LaravelRestable\Tests\Fixtures\Dream;
use Illuminate\Http\Request;

class SortTest extends TestCase
{
    public function test_can_sort_attribute(): void
    {
        Dream::factory(5)->create();

        Dream::factory()->state([
            'dream' => 'aaa',
        ])->create();

        Dream::factory()->state([
            'dream' => 'zzz',
        ])->create();

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            'sort' => 'dream',
        ]));

        Dream::$sort = [
            'dream',
        ];

        $this->assertEquals('aaa', Dream::search($request)->first()->dream);
        $this->assertEquals('zzz', Dream::search($request)->get()->last()->dream);

        // Desc.

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            'sort' => '-dream',
        ]));

        $this->assertEquals('zzz', Dream::search($request)->first()->dream);
        $this->assertEquals('aaa', Dream::search($request)->get()->last()->dream);
    }
}
