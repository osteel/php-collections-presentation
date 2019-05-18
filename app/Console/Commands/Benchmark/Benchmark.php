<?php

namespace App\Console\Commands\Benchmark;

use Illuminate\Console\Command;

class Benchmark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark {quantity : the number of pokemons}';

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
        $quantity = $this->argument('quantity');
        foreach (['imperative', 'higher', 'collections'] as $command) {
            $average = $this->command($command, $quantity);
            $this->info(sprintf(
                'The average time it took to process %s pokemons with method "%s" was %s sec',
                $quantity,
                $command,
                $average
            ));
        }
    }

    private function command(string $command, int $quantity)
    {
        $times = [];

        for ($i = 0; $i < 10; $i ++) {
            $t1 = microtime(true);
            $this->call($command, ['file' => sprintf('%s.json', $quantity)]);
            $t2 = microtime(true);
            $times[] = $t2 - $t1;
        }

        return collect($times)->avg();
    }
}
