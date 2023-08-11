<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Setting;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(255);

        $site_logo = Setting::where('name', 'site_logo')->first();
        view()->share('site_logo', $site_logo->getFirstMediaUrl('settings'));

        view()->share('default_img_url', url()->asset('/assets/frontend/images/img_not_available.png'));
    }
}
