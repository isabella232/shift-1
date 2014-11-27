<?php
namespace Tectonic\Shift\Modules\Accounts\Facades;

use Illuminate\Support\Facades\Facade;

class CurrentAccount extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'current.account';
    }
}
