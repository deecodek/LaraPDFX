<?php

namespace Deecodek\LaraPDFX;

use Deecodek\LaraPDFX\Console\InstallCommand;
use Deecodek\LaraPDFX\Console\TestCommand;
use Illuminate\Support\ServiceProvider;

class LaraPDFXServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/larapdfx.php', 'larapdfx'
        );

        $this->app->singleton('larapdfx', function ($app) {
            return new PDF;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/larapdfx.php' => config_path('larapdfx.php'),
            ], 'larapdfx-config');

            $this->commands([
                InstallCommand::class,
                TestCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'larapdfx');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['larapdfx'];
    }
}
