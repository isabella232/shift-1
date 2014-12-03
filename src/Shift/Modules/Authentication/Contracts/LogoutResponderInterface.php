<?php
namespace Tectonic\Shift\Modules\Authentication\Contracts;

use Illuminate\Auth\UserInterface;

interface LogoutResponderInterface
{
    /**
     * When logout has succeeded, handle the necessary response.
     *
     * @param \Illuminate\Auth\UserInterface $user
     *
     * @return mixed
     */
    public function onSuccess(UserInterface $user);
}