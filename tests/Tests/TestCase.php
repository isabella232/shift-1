<?php

namespace Tests;

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
}
