<?php

namespace Tests;

use DB;
use Exception;
use Illuminate;
use Mockery as m;
use Symfony;

class TestCase extends \Orchestra\Testbench\TestCase
{
	public function tearDown()
	{
		m::close();
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
            'Validator' => 'Illuminate\Support\Facades\Validator',
        ];
    }

	public function setUp()
	{
		parent::setUp();

		$artisan = $this->app->make('artisan');

		$artisan->call('migrate', [
            '--database' => 'test',
			'--path' => 'src/migrations'
		]);

        // Sanity check. This will fail if migrations failed.
        DB::table('roles')->get();
	}
}
