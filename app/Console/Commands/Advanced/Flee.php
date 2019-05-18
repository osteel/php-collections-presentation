<?php

namespace App\Console\Commands\Advanced;

use App\Pokemon;
use Illuminate\Console\Command;

class Flee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced example: flee if you can!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path('pokedex.json')), true);

        $pokedex = collect($dataset)
            ->mapInto(Pokemon::class)
            ->keyBy('name');

        $arceus = $pokedex->get('Arceus');

        $pokedex
            ->reject(function (Pokemon $pokemon) use ($arceus) {
                return $arceus->abilities->speed >= $pokemon->abilities->speed;
            })
            ->each->flee();
    }
}
