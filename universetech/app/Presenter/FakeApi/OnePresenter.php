<?php

namespace App\Presenter\FakeApi;

class OnePresenter
{
    public function json($data, $errorCode = 0)
    {
        $result = [
            'result' => [
                'cache' => 0,
                'data' => $data
            ],
            'errorCode' => $errorCode
        ];

        return response()->json($result, 200);
    }

}
