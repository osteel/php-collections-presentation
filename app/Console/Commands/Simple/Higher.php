<?php

namespace App\Console\Commands\Simple;

use App\Pokemon;
use Illuminate\Console\Command;

class Higher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'higher {file=pokedex.json : the pokedex to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple example: declarative style - higher order functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path($this->argument('file'))), true);

        $attack = array_reduce(
            array_filter(
                array_map(
                    function (array $attributes) {
                        return new Pokemon($attributes);
                    },
                    $dataset
                ),
                function (Pokemon $pokemon) {
                    return $pokemon->isType('fire');
                }
            ),
            function (int $attack, Pokemon $pokemon) {
                return $pokemon->abilities->attack > $attack ? $pokemon->abilities->attack : $attack;
            },
            0
        );

        $this->info(sprintf('The highest attack of pokemons of type fire is %s', $attack));
    }
}
