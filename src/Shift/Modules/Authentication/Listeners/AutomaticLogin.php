<?php
namespace Tectonic\Shift\Modules\Authentication\Listeners;

use Auth;

class AutomaticLogin
{
	public function whenUserHasRegistered(UserHasRegistered $event)
    {
        Auth::login($event->user);
    }
}
