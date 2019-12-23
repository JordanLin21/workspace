<?php

namespace App\Service\Crawler;

use Illuminate\Support\Facades\Log;
use App\Exceptions\FetchFailureException;
use App\Interfaces\Lottery;

class Crawler
{
    protected $lottery;
    protected $agents;

    public function __construct(Lottery $lottery)
    {
        $this->lottery = $lottery;
        $this->agents = [
            '\App\Service\Crawler\AgentOne',
            '\App\Service\Crawler\AgentTwo'
        ];
        $this->changeAgentPriority();
    }

    public function getWinningNumber()
    {
        if (!in_array($this->lottery->gameId, [1, 2])) {
            Log::error(sprintf('gameId [%d] not Implement.', $this->lottery->gameId));
            throw new FetchFailureException('gameId not Implement.');
        }

        try {
            foreach ($this->agents as $agent) {
                $instance = new $agent($this->lottery);
                $data = $instance->fetch();
                if ($data) {
                    return $data;
                }
            }
            throw new FetchFailureException('all Agent failed');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new FetchFailureException('Error');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FetchFailureException('Error');
        }
    }

    private function changeAgentPriority()
    {
        if ($this->lottery->gameId == 2){
            $this->agents = [
                $this->agents[1],
                $this->agents[0],
            ];
        }
    }
}