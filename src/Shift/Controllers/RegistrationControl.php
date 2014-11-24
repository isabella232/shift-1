<?php
namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

class RegistrationController extends Controller
{
    public function form()
    {
        return $this->respond('shift::users.register');
    }

    public function register()
    {

    }
}
