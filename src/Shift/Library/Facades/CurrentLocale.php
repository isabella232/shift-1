<?php
namespace Tectonic\Shift\Library\Facades;

use Illuminate\Support\Facades\Facade;

class CurrentLocale extends Facade
{
	public static function getFacadeAccessor() { return 'currentLocale'; }
}
