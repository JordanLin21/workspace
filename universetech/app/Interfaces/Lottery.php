<?php

namespace App\Interfaces;

class Lottery
{
    public $gameId;
    public $issue;

    public function __construct($gameId, $issue)
    {
        $this->gameId = $gameId;
        $this->issue = $issue;
    }

    public function update($data) {
        error_log('gameId: ' . $this->gameId);
        error_log('issue: ' . $this->issue);
        error_log('data: ' . json_encode($data));

        return true;
    }
}
