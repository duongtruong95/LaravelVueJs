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
        if (app()->environment(['local', 'dev'])) {
            \DB::listen(
                function ($sql) {
                    foreach ($sql->bindings as $i => $binding) {
                        if ($binding instanceof \DateTime) {
                            $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                        } else {
                            if (is_string($binding)) {
                                $sql->bindings[$i] = "'$binding'";
                            }
                        }
                    }
                    // Insert bindings into query
                    $query = str_replace(['%', '?'], ['%%', '%s'], $sql->sql);

                    $query = vsprintf($query, $sql->bindings);

                    // Save the query to file
                    $logFile = fopen(
                        storage_path('logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_query.log'),
                        'a+'
                    );
                    fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL);
                    fclose($logFile);
                }
            );
        }
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
