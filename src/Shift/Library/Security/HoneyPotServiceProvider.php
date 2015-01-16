<?php
namespace Tectonic\Shift\Library\Security;

use Illuminate\Support\ServiceProvider;

class HoneyPotServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HoneyPot::class, function($app) {
            return new HoneyPot($app['config']->get('shift.honeypot.api_key', ''));
        });
    }
}
