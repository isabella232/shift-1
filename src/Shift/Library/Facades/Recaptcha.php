<?php
namespace Tectonic\Shift\Library\Facades;

use Illuminate\Support\Facades\Facade;

class Recaptcha extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'recaptcha';
	}
}
