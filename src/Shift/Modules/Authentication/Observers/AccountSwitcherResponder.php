<?php namespace Tectonic\Shift\Modules\Authentication\Observers;

use Illuminate\Support\Facades\Redirect;
use Tectonic\Shift\Library\Traits\Respondable;
use Tectonic\Shift\Modules\Authentication\Contracts\AccountSwitcherResponderInterface;

class AccountSwitcherResponder implements AccountSwitcherResponderInterface
{
    use Respondable;

    /**
     * Redirect the user to the account they wish to switch too.
     *
     * @param string $redirectUrl
     *
     * @return mixed
     */
    public function onSuccess($redirectUrl)
    {
        return Redirect::away($redirectUrl);
    }

    /**
     * Redirect user back to where they were.
     *
     * @return mixed
     */
    public function onFailure()
    {
        return Redirect::back();
    }
}