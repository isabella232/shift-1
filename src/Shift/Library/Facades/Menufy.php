<?php
namespace Tectonic\Shift\Library\Facades;

use Illuminate\Support\Facades\Facade;

class Menufy extends Facade
{
	public static function getFacadeAccessor()
    {
        return 'menufy';
    }
}
