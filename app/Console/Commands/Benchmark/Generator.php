<?php

namespace App\Console\Commands\Benchmark;

use Faker\Generator as Faker;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;

class Generator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate {quantity : the number of pokemons}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a pokedex with {quantity} pokemons';

    /**
     * Execute the console command.
     *
     * @param Faker      $faker
     * @param Filesystem $storage
     */
    public function handle(Faker $faker, Filesystem $storage)
    {
        $quantity = $this->argument('quantity');
        $dataset  = [];

        for ($i = 1; $i <= $quantity; $i ++) {
            $dataset[] = [
                'id'   => $i,
                'name' => ['english' => $faker->unique()->name],
                'type' => [
                    $faker->randomElement(['grass','fire','water','bug','normal','poison','electric','ground','fairy']),
                    $faker->randomElement(['fighting','psychic','rock','ghost','ice','dragon','dark','steel','flying']),
                ],
                'base' => [
                    'HP'          => $faker->numberBetween(10, 160),
                    'Attack'      => $faker->numberBetween(10, 160),
                    'Defense'     => $faker->numberBetween(10, 160),
                    'Sp. Attack'  => $faker->numberBetween(10, 160),
                    'Sp. Defense' => $faker->numberBetween(10, 160),
                    'Speed'       => $faker->numberBetween(10, 160),
                ],
            ];
        }

        $storage->put(sprintf('%s.json', $quantity), json_encode($dataset));
    }
}
