<?php

namespace App\Providers;

use App\Lib\Lang;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Lang::class, function(){
           return new Lang();
        });
    }
}
