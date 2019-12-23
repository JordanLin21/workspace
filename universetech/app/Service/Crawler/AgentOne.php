<?php

namespace App\Service\Crawler;

use Illuminate\Http\Request;
use App\Interfaces\Lottery;

class AgentOne
{
    protected $lottery;

    public function __construct(Lottery $lottery)
    {
        $this->lottery = $lottery;
    }

    public function fetch()
    {
        $params = [
            'gamekey' => $this->convertGamekey(),
            'issue' => $this->lottery->issue
        ];

        try {

            $request = Request::create('v1', 'GET', $params);
            $data = app()->handle($request)->getContent();
            $data = json_decode($data, true);
            if ($data['result']['data']) {
                return $data['result']['data'][0]['award'];
            }

        } catch (\Throwable $e) {
            return null;
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function convertGamekey()
    {
        $i = $this->lottery->gameId;
        if ($i == 1) {
            return 'ssc';
        } elseif ($i == 2) {
            return 'bjsyxw';
        }
        return null;
    }
}