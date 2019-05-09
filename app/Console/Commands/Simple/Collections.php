<?php

namespace App\Console\Commands\Simple;

use App\Pokemon;
use Illuminate\Console\Command;

class Collections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collections {file=pokedex.json : the pokedex to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple example: declarative style - Laravel collections';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path($this->argument('file'))), true);

        $attack = collect($dataset)
            ->mapInto(Pokemon::class)
            ->filter->isType('fire')
            ->map(function (Pokemon $pokemon) {
                return $pokemon->abilities->attack;
            })
            ->max();

        $this->info(sprintf('The highest attack of pokemons of type fire is %s', $attack));
    }
}
