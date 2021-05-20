<?php

namespace App\Console\Commands;

use App\Models\Deck;
use Illuminate\Console\Command;

class StartGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It is a test written for senior php developer quiz.';
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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
