<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Library\MatchDates;

class MatchDatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dates:match';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Match all date applications';

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
        $a = new MatchDates();
        $a->test();
    }
}
