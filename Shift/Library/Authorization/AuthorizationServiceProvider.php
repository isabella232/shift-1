<?php namespace Tectonic\Shift\Library\Authorization;

use App;
use Event;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
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
	 * Here we register our authenticated consumer
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
