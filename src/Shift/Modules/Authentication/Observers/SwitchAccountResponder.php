<?php namespace Tectonic\Shift\Modules\Authentication\Observers;

use Illuminate\Support\Facades\Redirect;
use Tectonic\Shift\Controllers\AuthenticationController;
use Tectonic\Shift\Controllers\UserController;
use Tectonic\Shift\Modules\Authentication\Contracts\SwitchAccountResponderInterface;

class SwitchAccountResponder implements SwitchAccountResponderInterface
{

    /**
     * @return mixed
     */
    public function onSuccess()
    {
        return Redirect::action(UserController::class.'@profile');
    }

    /**
     * @return mixed
     */
    public function onFailure()
    {
        return Redirect::action(AuthenticationController::class.'@login');
    }
}