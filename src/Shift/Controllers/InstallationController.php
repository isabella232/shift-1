<?php

namespace Tectonic\Shift\Controllers;

use Request;
use Tectonic\Shift\Library\Support\Controller;
use View;

class InstallationController extends Controller
{
    public $layout = 'shift::layouts.installation';

    public function getInstall()
    {
        $host = Request::getHttpHost();

        return View::make('shift::installation.setup', compact('host'));
    }

    public function postInstall()
    {

    }
}
