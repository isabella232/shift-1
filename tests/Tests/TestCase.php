<?php

namespace Tests;

use Illuminate;
use Symfony;

class TestCase extends \Orchestra\Testbench\TestCase
{
	protected function getPackageProviders()
	{
		return array('Tectonic\Shift\ShiftServiceProvider');
	}
}
