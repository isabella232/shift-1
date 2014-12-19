<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Authentication\Observers\LogoutResponder;
use Tectonic\Shift\Modules\Authentication\Services\AccountSwitcherService;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;
use Tectonic\Shift\Modules\Authentication\Observers\AuthenticationResponder;

class AuthenticationController extends Controller
{
    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @var \Tectonic\Shift\Modules\Authentication\Services\AccountSwitcherService
     */
    protected $accountSwitcherService;

    /**
     * @param AuthenticationService                                                  $authenticationService
     * @param \Tectonic\Shift\Modules\Authentication\Services\AccountSwitcherService $accountSwitcherService
     */
    public function __construct(AuthenticationService $authenticationService, AccountSwitcherService $accountSwitcherService)
    {
        $this->authenticationService = $authenticationService;
        $this->accountSwitcherService = $accountSwitcherService;
    }

    /**
     * Handle authentication
     *
     * @return mixed
     */
    public function login()
    {
        return $this->authenticationService->login(Input::get(), new AuthenticationResponder);
    }

    /**
     * Handle logging out of user.
     *
     * @return mixed
     */
    public function logout()
    {
        return $this->authenticationService->logout(Auth::user(), new LogoutResponder);
    }

    /**
     * Handle collecting a list of accounts the current user belongs to.
     *
     * @return mixed
     */
    public function getAccounts()
    {
        return $this->accountSwitcherService->getUserAccounts();
    }

    /**
     * Handle switching to another account
     *
     * @param $id
     *
     * @return mixed
     */
    public function switchAccount($id)
    {
        return $this->accountSwitcherService->switchToAccount($id);
    }

}