<?php
namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

class RootController extends Controller
{
	public function index()
    {
        return $this->respond('shift::home.index');
    }
}
