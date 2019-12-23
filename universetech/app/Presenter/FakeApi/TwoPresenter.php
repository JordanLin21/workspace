<?php

namespace App\Presenter\FakeApi;

class TwoPresenter
{
    public function json($data, $code)
    {
        $result = [
            'rows' => count($data),
            'code' => $code,
            'data' => $data,
        ];

        return response()->json($result, 200);
    }

}
