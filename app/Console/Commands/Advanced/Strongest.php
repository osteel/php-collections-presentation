<?php

namespace App\Console\Commands\Advanced;

use App\Pokemon;
use Illuminate\Console\Command;

class Strongest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strongest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced example: strongest pokemon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path('pokedex.json')), true);
        $pokedex = collect($dataset)->mapInto(Pokemon::class);

        $strongest = $pokedex
            ->sortByDesc(function (Pokemon $pokemon) {
                return $pokemon->abilities->sum();
            })
            ->first();

        $this->info('Strongest pokemon:');
        $this->info(print_r($strongest));
    }
}
