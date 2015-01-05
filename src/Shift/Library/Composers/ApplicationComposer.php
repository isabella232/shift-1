<?php namespace Tectonic\Shift\Library\Composers; 

use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;

class ApplicationComposer
{
    public function compose($view)
    {
        $view->with('account', CurrentAccount::translated());
    }
}