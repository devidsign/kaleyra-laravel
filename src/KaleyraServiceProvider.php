<?php

namespace Idsign\Kaleyra;

use Idsign\Kaleyra\Http\Livewire\RegistrationDownload;
use Idsign\Kaleyra\Http\Livewire\RegistrationModal;
use Illuminate\Support\Facades\Route;
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
        $this->mergeConfigFrom(__DIR__ . '/../config/bandyer.php', 'bandyer');

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
            __DIR__ . '/../config/bandyer.php' => config_path('bandyer.php'),
        ]);

    }
}
