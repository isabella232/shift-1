<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Authentication\Observers\AccountSwitcherResponder;
use Tectonic\Shift\Modules\Authentication\Observers\LogoutResponder;
use Tectonic\Shift\Modules\Authentication\Observers\SwitchAccountResponder;
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
     * @var AccountSwitcherService
     */
    protected $accountSwitcherService;

    /**
     * @param AuthenticationService $authenticationService
     * @param AccountSwitcherService $accountSwitcherService
     */
    public function __construct(AuthenticationService $authenticationService, AccountSwitcherService $accountSwitcherService)
    {
        $this->authenticationService = $authenticationService;
        $this->accountSwitcherService = $accountSwitcherService;
    }

    /**
     * Handle authentication
     *
     * @Post("/login", middleware={"shift.account"}, prefix="/")
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
     * @Get("/logout", middleware={"shift.account", "auth"}, prefix="/")
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
     * @Get("/auth/accounts", middleware={"shift.account", "auth"}, prefix="/")
     *
     * @return mixed
     */
    public function getAccounts()
    {
        return $this->accountSwitcherService->getUserAccounts(Input::get());
    }

    /**
     * Handle switching to another account
     *
     * @Get("/auth/account/{id}", middleware={"shift.account", "auth"}, prefix="/")
     *
     * @param $id
     *
     * @return mixed
     */
    public function switchToAccount($id)
    {
        return $this->accountSwitcherService->switchToAccount($id, new AccountSwitcherResponder);
    }

    /**
     * Handle switching to new account, logging in and redirecting to home page
     *
     * @Get("/auth/switch", middleware={"shift.account", "auth"}, prefix="/")
     *
     * @return mixed
     */
    public function switchAccount()
    {
        return $this->accountSwitcherService->switchAccount(Input::get('token'), new SwitchAccountResponder);
    }

}