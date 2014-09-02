<?php

namespace Tests;

use DB;
use Illuminate;
use Mockery as m;
use Symfony;
use Route;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Stores a response created by a call to the API.
     *
     * @var null
     */
    protected $response = null;

	public function tearDown()
	{
		m::close();

        $this->response = null;
	}

	protected function getPackageProviders()
	{
		return array('Tectonic\Shift\ShiftServiceProvider');
	}

	/**
	 * Define environment setup.
	 *
	 * @param  Illuminate\Foundation\Application    $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		// reset base path to point to our package's src directory
		$app['path.base'] = __DIR__ . '/../../';

		$app['config']->set('database.default', 'test');
		$app['config']->set('database.connections.test', array(
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => ''
		));
	}

    protected function getPackageAliases()
    {
        return [
            'Validator' => 'Illuminate\Support\Facades\Validator'
        ];
    }

	public function setUp()
	{
		parent::setUp();

        Route::disableFilters();

		$artisan = $this->app->make('artisan');

		$artisan->call('migrate', [
            '--database' => 'test',
			'--path' => 'src/migrations'
		]);

        // Sanity check. This will fail if migrations failed for whatever reason
        //@TODO: bring back DB::table('roles')->get();
	}

    /**
     * Most calls will return a JSON response. This method simply decodes
     * the response which you can use to validate the data returned.
     *
     * @param boolean $asArray
     * @param mixed $response
     * @return mixed
     */
    protected function parseResponse($asArray = false, $response = null)
    {
        if (is_null($response)) {
            $response = $this->response->getContent();
        }

        return json_decode($response, $asArray);
    }
}
