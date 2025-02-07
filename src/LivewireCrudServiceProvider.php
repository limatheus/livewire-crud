<?php

namespace Limatheus\LivewireCrud;

use Illuminate\Support\ServiceProvider;
use Limatheus\LivewireCrud\Commands\Crud;
use Limatheus\LivewireCrud\Commands\LivewireCrudView;

class LivewireCrudServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/livewire-crud.php', 'LivewireCrud');

        // Register the service the package provides.
        $this->app->singleton('LivewireCrud', function ($app) {
            return new LivewireCrud;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['LivewireCrud'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/livewire-crud.php' => config_path('livewire-crud.php'),
        ], 'livewire-crud.config');

        // Registering package commands.
        $this->commands([
            Crud::class,
            LiveCrudView::class
        ]);
    }
}
