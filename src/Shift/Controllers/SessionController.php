<?php
namespace Tectonic\Shift\Controllers;

use Auth;
use Illuminate\Routing\Controller;
use Input;
use Response;
use Tectonic\Shift\Modules\Sessions\Services\AuthService;
use Tectonic\Shift\Modules\Sessions\Validators\SessionValidation;

class SessionController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authenticationService;

    /**
     * @param SessionValidation $validator
     * @param AuthService $authenticationService
     */
    public function __construct(AuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Simple check to see whether or not a session is currently open.
     *
     * @return \Response
     */
    public function getIndex()
    {
        if ($this->authenticationService->hasOpenSession()) {
            return $this->authenticationService->user();
        }

        return Response::make(null, 401);
    }

    /**
     * Handle authentication and creation of a new session
     *
     * @return \Response
     */
    public function postStore()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        $remember = Input::get('remember', false);

        try {
            if ($this->authenticationService->login($username, $password, $remember)) {
                return Response::make(null, 200);
            }

            return Response::make(null, 400);
        } catch (\Exception $e) {
            return "Error occurred";
        }
    }

    /**
     * Handle the deletion of the current session
     *
     * @returns \Response
     */
    public function deleteIndex()
    {
        $this->authenticationService->logout();

        return Response::make(null, 200);
    }

}