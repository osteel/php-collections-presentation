<?php

namespace App\Providers;

use App\Pokemon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('sortByAbility', function (string $ability = null) {
            return $this->sortByDesc(function (Pokemon $pokemon) use ($ability) {
                return $ability ? $pokemon->abilities->$ability : $pokemon->abilities->sum();
            });
        });
    }
}
