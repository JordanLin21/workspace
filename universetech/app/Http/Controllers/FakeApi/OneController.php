<?php

namespace App\Http\Controllers\FakeApi;

use Illuminate\Http\Request;
use App\Presenter\FakeApi\OnePresenter;

class OneController extends FakeApiController
{

    public function __construct(OnePresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function getIssue(Request $request)
    {
        $request->validate([
            'gamekey' => 'required',
            'issue' => 'required'
        ]);

        $data = [];
        $data[] = [
            "gid" => $request->input('issue'),
            "award" => $this->randomAward(),
            "updatetime" => strval(now()->timestamp)
        ];

        return $this->presenter->json($data);
    }

}
