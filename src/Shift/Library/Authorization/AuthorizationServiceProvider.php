<?php
namespace Tectonic\Shift\Library\Authorization;

use App;
use Event;
use Illuminate\Foundation\AliasLoader;
use Tectonic\Shift\Library\Authorization\ConsumerManager;
use Tectonic\Shift\Library\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
	/**
	 * Defer the loading of auth.
	 *
	 * @var bool
	 */
	public $defer = true;

	/**
	 * A collection of custom aliases to register.
	 *
	 * @var array
	 */
	protected $aliases = [
		'Consumer' => 'Tectonic\Shift\Library\Facades\Consumer',
	];

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		parent::register();

        $this->registerConsumer();
    }

	/**
	 * Here we register our authenticated consumer
	 */
	public function registerConsumer()
	{
		$this->app->singleton('consumer.manager', ConsumerManager::class);
	}

	/**
	 * Return the classes and objects provided by this service provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['consumer.manager', 'Consumer'];
	}
}
