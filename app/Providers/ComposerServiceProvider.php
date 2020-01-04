<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        view()->composer(['modules.header-bar', 'modules.nav-bar'], 'App\Http\Composers\HeaderProfileComposer');
        view()->composer('modules.right-sidebar', 'App\Http\Composers\NotificationComposer');

    }

    /**
     * @return void
     */
    public function register()
    {
        //
    }
}