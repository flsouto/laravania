<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\TextureMaker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(TextureMaker::class, function(){
            $tm = new TextureMaker(
                config('texture.in_glob'),
                config('texture.out_width'),
                config('texture.out_height'),
            );
            return $tm;
        });

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
