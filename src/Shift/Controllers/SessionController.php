<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

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
     * @param int|null $id
     * @returns \Response
     */
    public function deleteIndex($id = null)
    {
        
    }

}