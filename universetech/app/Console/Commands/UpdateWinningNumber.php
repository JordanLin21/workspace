<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\Lottery;
use App\Service\UpdateWinningNumberJob;

class UpdateWinningNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateWinningNumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UpdateWinningNumber';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $issue =  now()->format('Ymd') . '001';
        for ($i = 1; $i <= 3; $i++) {
            $job = new UpdateWinningNumberJob(new Lottery($i, $issue));
            $job->handle();
        }
    }
}
