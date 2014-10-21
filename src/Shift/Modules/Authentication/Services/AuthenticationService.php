<?php
namespace Tectonic\Shift\Modules\Authentication\Services;

use Illuminate\Auth\Guard;

class AuthenticationService
{
    /**
     * @var Guard
     */
    protected $authentication;

    /**
     * @param Guard $authentication
     */
    public function __construct(Guard $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Attempt login / start session
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember
     *
     * @return bool
     */
    public function login($username, $password, $remember = false)
    {
        return $this->authentication->attempt(['username' => $username, 'password' => $password], $remember);
    }

    /**
     * Logout / destroy session
     */
    public function logout()
    {
        $this->authentication->logout();
    }

    /**
     * Check to see if there's an open session current
     *
     * @return bool
     */
    public function hasOpenSession()
    {
        return $this->authentication->check();
    }

    /**
     * Get the user belonging to the current open session
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function user()
    {
        return $this->authentication->getUser();
    }
}