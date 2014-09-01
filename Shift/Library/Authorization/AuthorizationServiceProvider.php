<?php namespace Tectonic\Shift;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Tectonic\Shift\Library\Authorization\AuthenticatedConsumer;
use Tectonic\Shift\Library\Router;
use App;

class ShiftServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerAuthenticatedConsumer();
    }

	/**
	 * Register the various classes required to Bootstrap Shift
	 */
	public function boot()
	{
		$this->package('tectonic/shift');
	}

	/**
	 * Here we register our own custom view finder, which extends the one that Laravel uses.
	 */
	public function registerAuthenticatedConsumer()
	{
        $loginHandler = function() {
            $this->app->bindShared('AuthenticatedConsumer', function($app) {
                return;
            });
        };

        $loginHandler->bindTo($this);

		Event::listen('login.successful', $loginHandler);
	}
}
