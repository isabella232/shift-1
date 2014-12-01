<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Illuminate\Support\Facades\Auth;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Authentication\Observers\AuthenticationResponder;
use Tectonic\Shift\Modules\Authentication\Observers\LogoutResponder;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @param AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Simple check to see whether or not a session is currently open.
     *
     * @return \Response
     */
    public function form()
    {
        $this->respond('shift::authentication.login');
    }

    /**
     * Handle authentication
     */
    public function login()
    {
        return $this->authenticationService->login(Input::get(), new AuthenticationResponder);
    }

    /**
     * Handle logging out of user.
     */
    public function logout()
    {
        return $this->authenticationService->logout(Auth::user(), new LogoutResponder);
    }

}