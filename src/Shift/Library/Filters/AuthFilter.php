<?php
namespace Tectonic\Shift\Library\Filters;

use Auth;
use Consumer;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Redirect;
use Tectonic\Shift\Library\Authorization\UserConsumer;

/**
 * Class AuthFilter
 *
 * The auth filter manages the logic surrounding setting up consumer data that is dependent on sessions.
 *
 * @package Tectonic\Shift\Library\Filters
 */
class AuthFilter
{
    /**
     * @param Route $route
     * @param Request $request
     */
    public function filter(Route $route, Request $request)
    {
        if (Auth::guest()) {
            return Redirect::to('/');
        }
        else {
            Consumer::set(new UserConsumer(Auth::user()));
        }
    }
}
