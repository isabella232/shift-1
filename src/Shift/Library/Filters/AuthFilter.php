<?php
namespace Tectonic\Shift\Library\Filters;

class AuthFilter
{
    /**
     * @param $route
     * @param $request
     */
    public function filter($route, $request)
    {
        if (Auth::guest()) {
            return Redirect::to('/');
        }


    }
}
