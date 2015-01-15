<?php
namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;

/**
 * Class HomeController
 *
 * The home controller is the first route or page a new visitor will see when visiting Shift. This request manages the
 * registration and login forms, as they're both shown - but ensures that the appropriate service and controllers deal
 * with those requests individually.
 *
 * @package Tectonic\Shift\Controllers
 */
class HomeController extends Controller
{
    /**
     * @Get("/", as="home", middleware={"shift.account"})
     *
     * @return mixed
     */
	public function index()
    {
        return view('shift::home.index');
    }
}
