<?php

namespace App\Providers;


use App\Exceptions\AppRuntimeException;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        }

        $table = config('admin.extensions.config.table', 'admin_config');
        if (Schema::hasTable($table)) {
            \Encore\Admin\Config\Config::load();
        }


        app('Dingo\Api\Exception\Handler')->register(function (\Throwable $exception) {
            if ($exception instanceof AppRuntimeException) {
               return $exception::render(request(), $exception);
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);

        }
    }
}
