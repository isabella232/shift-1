<?php namespace Tectonic\Shift\Controllers;

use Auth;
use Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Sessions\Services\AuthenticationService;
use Tectonic\Shift\Modules\Sessions\Validators\SessionValidation;

class SessionController extends Controller
{
    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @param SessionValidation $validator
     * @param AuthenticationService $authenticationService
     */
    public function __construct(SessionValidation $validator, AuthenticationService $authenticationService)
    {
        $this->validator = $validator;
        $this->authenticationService = $authenticationService;
    }

    /**
     * Simple check to see whether or not a session is currently open.
     *
     * @return \Response
     */
    public function getIndex()
    {
        if($this->authenticationService->hasOpenSession())
        {
            return $this->authenticationService->user();
        }

        return $this->response(401);
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

        if($this->authenticationService->login($username, $password, $remember))
        {
            return $this->response(200);
        }

        return $this->response(401);
    }

    /**
     * Handle the deletion of the current session
     *
     * @returns \Response
     */
    public function deleteIndex()
    {
        $this->authenticationService->logout();

        return $this->respond( 200 );
    }

}