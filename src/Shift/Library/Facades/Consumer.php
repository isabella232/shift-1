<?php
namespace Tectonic\Shift\Library\Facades;

use Illuminate\Support\Facades\Facade;

class Consumer extends Facade
{
	public static function getFacadeAccessor() { return 'consumer.manager'; }
}
