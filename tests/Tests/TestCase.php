<?php

namespace Tests;

use Mockery as m;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Reset the test case to its base level test status, clearing mocks.
     */
    public function tearDown()
	{
		m::close();
	}

	protected function getPackageProviders()
	{
		return [
            'Tectonic\Shift\ShiftServiceProvider'
        ];
	}

	/**
	 * Define environment setup.
	 *
	 * @param  Illuminate\Foundation\Application $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		// reset base path to point to our package's src directory
		$app['path.base'] = __DIR__ . '/../../';
	}

    protected function getPackageAliases()
    {
        return [
            'Validator' => 'Illuminate\Support\Facades\Validator'
        ];
    }
}
