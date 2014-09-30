<?php namespace Tectonic\Shift\Controllers;

use Auth;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Sessions\Validators\SessionValidator;

class SessionController extends Controller
{
    public function __construct(SessionValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Simple check to see whether or not the user has logged in, and returns
     * details back as a response.
     *
     * @return \Response
     */
    public function getIndex()
    {
        if(Auth::check()) return Auth::user();

        return $this->response( 401 );
    }

    /**
     * Handles the input posted from the form for user login and returns with an appropriate response
     *
     * @return \Response
     */
    public function postIndex()
    {
        
    }

    /**
     * Handle the deletion of session management for a given user session
     *
     * @returns \Response
     */
    public function deleteIndex()
    {
        $user = Auth::user();
        Auth::logout();

        //Event::fire( 'session.logout', [ $user ] );

        return $this->respond( 200 );
    }

}