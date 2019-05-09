<?php

namespace App\Console\Commands;

use App\Pokemon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class Sandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests, notes, drafts...';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = json_decode(file_get_contents(storage_path('pokedex.json')), true);

        // STEP ONE

        // imperative
        $pokedex = [];
        foreach ($dataset as $attributes) {
            $pokedex[] = new Pokemon($attributes);
        }

        // PHP's higher order functions

        $pokedex = array_map(
            function (array $attributes) {
                return new Pokemon($attributes);
            },
            $dataset
        );

        // collections

        $pokedex = collect($dataset)
            ->map(function (array $attributes) {
                return new Pokemon($attributes);
            });

        // STEP TWO

        // imperative

        $pokedex = [];
        foreach ($dataset as $attributes) {
            $pokemon = new Pokemon($attributes);
            if ($pokemon->isType('fire')) {
                $pokedex[] = $pokemon;
            }
        }

        // PHP's higher order functions

        $pokedex =
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
            );

        // collections

        $pokedex = collect($dataset)
            ->map(function (array $attributes) {
                return new Pokemon($attributes);
            })
            ->filter(function (Pokemon $pokemon) {
                return $pokemon->isType('fire');
            });


        new \Illuminate\Support\Collection([1, 2, 3]);

        collect([1, 2, 3]);

        // STEP THREE

        // imperative

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

        // PHP's higher order functions

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

        // collections

        $attack = collect($dataset)
            ->map(function (array $attributes) {
                return new Pokemon($attributes);
            })
            ->filter(function (Pokemon $pokemon) {
                return $pokemon->isType('fire');
            })
            ->reduce(function (int $attack, Pokemon $pokemon) {
                return $pokemon->abilities->attack > $attack ? $pokemon->abilities->attack : $attack;
            }, 0);

        $attack = collect($dataset)
            ->mapInto(Pokemon::class)
            ->filter(function (Pokemon $pokemon) {
                return $pokemon->isType('fire');
            })
            ->reduce(function (int $attack, Pokemon $pokemon) {
                return $pokemon->abilities->attack > $attack ? $pokemon->abilities->attack : $attack;
            }, 0);

        $attack = collect($dataset)
            ->mapInto(Pokemon::class)
            ->filter->isType('fire')
            ->reduce(function (int $attack, Pokemon $pokemon) {
                return $pokemon->abilities->attack > $attack ? $pokemon->abilities->attack : $attack;
            }, 0);

        $attack = collect($dataset)
            ->mapInto(Pokemon::class)
            ->filter->isType('fire')
            ->map(function (Pokemon $pokemon) {
                return $pokemon->abilities->attack;
            })
            ->max();

        // ADVANCED
        $pokedex = collect($dataset)->mapInto(Pokemon::class);

        // Group the pokemons by type and for each type display the total of all of its pokemons' skills (use pipe).
        $result = $pokedex->groupBy->types;
        //\Log::debug(print_r($result->toArray(), true));

        $result = $pokedex
            ->groupBy(function (Pokemon $pokemon) {
                return $pokemon->types;
            })
            ->map(function (Collection $pokemons) {
                return $pokemons->reduce(function (int $score, Pokemon $pokemon) {
                    return $score + $pokemon->abilities->sum();
                }, 0);
            })
            ->sort()
            ->reverse();
        //$result = $pokedex->groupBy->types;

        \Log::debug(print_r($result->toArray(), true));
        // Key the collection by name.
        $pokedex = $pokedex->keyBy('name');

        // Find the most dangerous pokemon (highest sum of all of its skills).
        $result = $pokedex
            ->sortByDesc(function (Pokemon $pokemon) {
                return $pokemon->abilities->sum();
            })
            ->first();

        $arceus = $pokedex->get('Arceus');

        $pokedex
            ->reject(function (Pokemon $pokemon) use ($arceus) {
                return $arceus->abilities->speed >= $pokemon->abilities->speed;
            })
            ->each(function (Pokemon $pokemon) {
                $pokemon->flee();
            });

        $pokedex
            ->reject(function (Pokemon $pokemon) use ($arceus) {
                return $arceus->abilities->attack >= $pokemon->abilities->defense;
            })
            ->each(function (Pokemon $pokemon) {
                $pokemon->defend();
            });

        $pokedex
            ->reject(function (Pokemon $pokemon) use ($arceus) {
                return $arceus->abilities->defense > $pokemon->abilities->attack;
            })
            ->each(function (Pokemon $pokemon) {
                $pokemon->attack();
            });

        $result = $pokedex->sortByAbility('spAttack')->take(5);
        \Log::debug(print_r($result, true));

        $result = $pokedex->sortByAbility()->take(5);
        \Log::debug(print_r($result, true));

        $result = $pokedex->filter->isType('water')->sortByAbility()->last();
        \Log::debug(print_r($result, true));

        $types = $pokedex->map(function (Pokemon $pokemon) {
            return $pokemon->types[0];
        })->unique()->implode("','");
        \Log::debug($types);
    }
}
