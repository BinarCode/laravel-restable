<?php

namespace BinarCode\LaravelRestable\Tests;

use BinarCode\LaravelRestable\Filters\MatchFilter;
use BinarCode\LaravelRestable\Tests\Fixtures\Dream;
use BinarCode\LaravelRestable\Types;
use Illuminate\Http\Request;

class MatchTest extends TestCase
{
    public function test_can_match_attribute(): void
    {
        Dream::factory(10)->create();

        Dream::factory()
            ->state([
                'dream' => 'enjoy',
            ])
            ->create();

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            'dream' => 'enjoy',
        ]));

        Dream::$match = [
            'dream' => Types::MATCH_TEXT,
        ];

        $pagination = Dream::search($request)->paginate();

        $this->assertCount(1, $pagination->items());
    }

    public function test_can_customize_match_defition(): void
    {
        Dream::factory(10)->create();

        Dream::factory()
            ->state([
                'dream' => 'enjoy',
            ])
            ->create();

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            'dream' => 'enjoy',
        ]));

        Dream::$match = ['dream' => MatchFilter::make()]; //Detect key as column.
        $this->assertCount(1, Dream::search($request)->paginate()->items());

        Dream::$match = ['dream' => MatchFilter::make()->setMatchType('text')];
        $this->assertCount(1, Dream::search($request)->paginate()->items());

        Dream::$match = ['dream' => MatchFilter::make()->setMatchType('text')->setColumn('dreams.dream')];
        $this->assertCount(1, Dream::search($request)->paginate()->items());

        Dream::$match = ['dream' => MatchFilter::make()->setColumn('dream')];
        $this->assertCount(1, Dream::search($request)->paginate()->items());
    }

    public function test_can_match_negation(): void
    {
        Dream::factory(10)->create();

        Dream::factory()
            ->state([
                'dream' => 'enjoy',
            ])
            ->create();

        $request = tap(new Request([], []), fn (Request $request) => $request->merge([
            '-dream' => 'enjoy',
        ]));

        Dream::$match = ['dream' => MatchFilter::make()->setColumn('dreams.dream')];

        $this->assertCount(10, Dream::search($request)->paginate()->items());

        Dream::$match = ['dream' => 'text'];

        $this->assertCount(10, Dream::search($request)->paginate()->items());

        Dream::$match = ['dream' => MatchFilter::make()->setColumn('dream')];

        $this->assertCount(10, Dream::search($request)->paginate()->items());
    }
}
