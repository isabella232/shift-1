<?php namespace Tectonic\Shift\Modules\Authentication\Observers; 

use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\Redirect;
use Tectonic\Shift\Modules\Authentication\Contracts\LogoutResponderInterface;

class LogoutResponder implements LogoutResponderInterface
{

    /**
     * When logout has succeeded, handle the necessary response.
     *
     * @param \Illuminate\Auth\UserInterface $user
     *
     * @return mixed
     */
    public function onSuccess(UserInterface $user)
    {
        return Redirect::to('/login');
    }
}