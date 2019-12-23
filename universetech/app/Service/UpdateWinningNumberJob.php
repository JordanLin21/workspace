<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use App\Exceptions\FetchFailureException;
use App\Interfaces\Lottery;
use App\Service\Crawler\Crawler;

class UpdateWinningNumberJob
{
    protected $lottery;

    public function __construct(Lottery $lottery)
    {
        $this->lottery = $lottery;
    }

    public function handle()
    {
        try {

            $target = new Crawler($this->lottery);
            $this->lottery->update([
                'winning_number' => $target->getWinningNumber()
            ]);

        } catch (FetchFailureException $e) {
            Log::error('Something went wrong.');
        }
    }
}