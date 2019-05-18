<?php

namespace App\Console\Commands\Advanced;

use App\Pokemon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class Type extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced example: sum of abilities per type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path('pokedex.json')), true);
        $pokedex = collect($dataset)->mapInto(Pokemon::class);

        $abilities = $pokedex
            ->groupBy('types')
            ->map->reduce(function (int $score, Pokemon $pokemon) {
                return $score + $pokemon->abilities->sum();
            }, 0)
            ->sort()
            ->each(function (int $total, string $type) {
                $this->info(sprintf('=> The sum of the abilities of pokemons of type %s is: %s', $type, $total));
            });
    }
}
