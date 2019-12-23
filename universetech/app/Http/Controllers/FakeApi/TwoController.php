<?php

namespace App\Http\Controllers\FakeApi;

use Illuminate\Http\Request;
use App\Presenter\FakeApi\TwoPresenter;

class TwoController extends FakeApiController
{

    public function __construct(TwoPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function getOpenCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->input('code');
        $now = now();

        $data = [];
        for ($i = 1; $i <= 3; $i++) {
            $data[] = [
                 "expect" => $now->format('Ymd') . str_pad($i, 3, "0", STR_PAD_LEFT),
                 "opencode" => $this->randomAward(),
                 "opentime" => $now->toDateTimeString(),
            ];
            $now->subMinute(rand(1, 100));
        }

        return $this->presenter->json($data, $code);
    }

}
