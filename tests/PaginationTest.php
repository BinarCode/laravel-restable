<?php

namespace BinarCode\LaravelRestable\Tests;


use BinarCode\LaravelRestable\Tests\Fixtures\Dream;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PaginationTest extends TestCase
{
    public function test_can_paginate_model(): void
    {
        Dream::factory(10)->create();

        $request = tap(new Request([], []), fn(Request $request) => $request->merge([
            'perPage' => '5',
        ]));

        $pagination = Dream::search($request)->paginate();

        $this->assertSame(5, $pagination->perPage());
        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);
    }

    public function test_can_use_default_pagination(): void
    {
        Dream::factory(10)->create();

        $pagination = Dream::search(request())->paginate();

        $this->assertSame(Dream::$defaultPerPage, $pagination->perPage());
    }
}
