<?php

namespace App\Http\Controllers\FakeApi;

use Illuminate\Routing\Controller as BaseController;

class FakeApiController extends BaseController
{
    protected $presenter;

    protected function randomAward()
    {
        $numbers = range(1, 9);
        shuffle($numbers);
        return implode(',', array_slice($numbers, 0, 5));
    }
}
