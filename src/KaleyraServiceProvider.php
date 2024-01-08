<?php

namespace Idsign\Kaleyra;

use Illuminate\Support\ServiceProvider;

class KaleyraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/kaleyra.php', 'kaleyra_api');

        $this->app->bind('kaleyra', function () {
            return new Kaleyra();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/kaleyra.php' => config_path('kaleyra_api.php'),
        ]);

    }
}
