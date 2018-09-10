<?php

namespace Kingsley\NovaMediaLibrary;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\ServiceProvider;
use Kingsley\NovaMediaLibrary\Policies\MediaPolicy;

class NovaMediaLibraryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-media-library', __DIR__.'/../dist/js/app.js');
            Nova::style('nova-media-library', __DIR__.'/../dist/css/app.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
