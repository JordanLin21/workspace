<?php

namespace App\Service\Crawler;

use Illuminate\Http\Request;
use App\Interfaces\Lottery;

class AgentTwo
{
    protected $lottery;

    public function __construct(Lottery $lottery)
    {
        $this->lottery = $lottery;
    }

    public function fetch()
    {
        $issue = $this->lottery->issue;
        $params = [
            'code' => $this->convertCode(),
        ];

        try {

            $request = Request::create('newlydo', 'GET', $params);
            $data = app()->handle($request)->getContent();
            $data = json_decode($data, true);
            if (empty($data['data'])) {
                return null;
            }
            foreach ($row as $data['data']) {
                if ($row['expect'] == $issue) {
                    return $row['opencode'];
                }
            }

        } catch (\Throwable $e) {
            return null;
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function convertCode()
    {
        $i = $this->lottery->gameId;
        if ($i == 1) {
            return 'cqssc';
        } elseif ($i == 2) {
            return 'bj11x5';
        }
        return null;
    }
}