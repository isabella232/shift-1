<?php namespace Tectonic\Shift\Modules\Authentication\Contracts;

interface AccountSwitcherResponderInterface
{
    /**
     * Redirect the user to the account they wish to switch too.
     *
     * @param string $redirectUrl
     *
     * @return mixed
     */
    public function onSuccess($redirectUrl);

    /**
     * Redirect user back to where they were.
     *
     * @return mixed
     */
    public function onFailure();
}