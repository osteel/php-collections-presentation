<?php

namespace App\Console\Commands\Simple;

use App\Pokemon;
use Illuminate\Console\Command;

class Imperative extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imperative {file=pokedex.json : the pokedex to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple example: imperative style';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path($this->argument('file'))), true);

        $attack = 0;
        foreach ($dataset as $attributes) {
            $pokemon = new Pokemon($attributes);
            if (! $pokemon->isType('fire')) {
                continue;
            }
            if ($pokemon->abilities->attack > $attack) {
                $attack = $pokemon->abilities->attack;
            }
        }

        $this->info(sprintf('The highest attack of pokemons of type fire is %s', $attack));
    }
}
