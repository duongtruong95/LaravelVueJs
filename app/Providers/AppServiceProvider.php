<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $repositories = [
        'Notification',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $repository) {
            $this->app->bind("App\Repositories\\{$repository}\\{$repository}RepositoryInterface",
                "App\Repositories\\{$repository}\\{$repository}Repository");
        }
        $this->app->bind("App\Repositories\BaseRepositoryInterface",
            "App\Repositories\BaseRepository");
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
