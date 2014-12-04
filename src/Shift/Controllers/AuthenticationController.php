<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Authentication\Observers\LogoutResponder;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;
use Tectonic\Shift\Modules\Authentication\Observers\AuthenticationResponder;

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