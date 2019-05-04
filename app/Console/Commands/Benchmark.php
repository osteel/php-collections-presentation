<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Benchmark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a performance benchmark comparing Laravel collections and PHP\'s higher order functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    }
}
