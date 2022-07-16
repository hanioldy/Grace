<?php

namespace Hani221b\Grace\Providers;

use Hani221b\Grace\Commands\InstallGrace;
use Hani221b\Grace\Helpers\ResourceRegistrar;
use Illuminate\Support\ServiceProvider;

class GraceServiceProvider extends ServiceProvider
{
    /**
     * Defining Grace package commands
     */
    protected $commands = [
        InstallGrace::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '../../Views', 'Grace');
        //adding new methods for a resoureful route
        $registrar = new ResourceRegistrar($this->app['router']);
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });
        //resgister commands
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('grace.status') === 'enabled') {
            include __DIR__ . '../../Routes/routes.php';
        }
        /**
         * publish package stuff
         */
        $this->publishes([
            //config
            __DIR__ . '..\\..\\Config\\grace.php' => config_path('grace.php'),
            //migrations
            __DIR__ . '..\\..\\Database\\Migrations\\2022_06_23_053830_create_languages_table.php' => base_path('database\\migrations\\2022_06_23_053830_create_languages_table.php'),
            //views
            __DIR__ . '..\\..\\Views\\Grace' => base_path('resources\\views\grace'),
            //assets
            __DIR__ . '..\\..\\Assets' => base_path('resources\\views\grace'),
            //models
            __DIR__ . '..\\..\\Models\\Language.php' => base_path('app\\Models\\Language.php'),
        ], 'grace');

    }
}
