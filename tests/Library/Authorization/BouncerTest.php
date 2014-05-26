<?php

use Mockery as m;
use Tectonic\Shift\Library\Authorization\Bouncer;

class BouncerTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testConsumerConstruction()
	{

	}
}
