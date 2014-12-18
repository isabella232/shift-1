<?php
namespace Tectonic\Shift\Library\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade
{
	public static function getFacadeAccessor() { return 'shift.translator'; }
}
