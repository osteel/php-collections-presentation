<?php

namespace App\Console\Commands\Advanced;

use App\Pokemon;
use Illuminate\Console\Command;

class Macro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'macro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced example: sort by ability using a macro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path('pokedex.json')), true);
        $pokedex = collect($dataset)->mapInto(Pokemon::class);

        // three strongest special attacks
        $pokemons = $pokedex->sortByAbility('spAttack')->take(3);

        // three strongest poison pokemons
        //$pokemons = $pokedex->filter->isType('poison')->sortByAbility()->take(3);

        // weakest water pokemon
        //$pokemon = $pokedex->filter->isType('water')->sortByAbility()->last();

        if (! empty($pokemons)) {
            $this->info($pokemons->toJson(JSON_PRETTY_PRINT));
        } else {
            $this->info(print_r($pokemon));
        }
    }
}
