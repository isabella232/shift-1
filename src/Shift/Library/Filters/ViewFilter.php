<?php
namespace Tectonic\Shift\Library\Filters;

use View;

class ViewFilter
{
    /**
     * Filters the response, generating a new one if necessary based on request requirements.
     *
     * @param object $route
     * @param object $request
     * @param object $response
     * @return Response
     */
    public function filter($route, $request, $response)
	{
        if ($this->isPjax($request)) {
            return $this->actionView($route);
        }

        if ($this->isJson($request)) {
            return $response;
        }

        return View::make('shift::layouts.application');
	}

    /**
     * Determines whether or not the current request has been created via a front-end PJAX implementation.
     *
     * @param object $request
     * @return bool
     */
    private function isPjax($request)
    {
        return !!$request->header('X-PJAX');
    }

    /**
     * Determines whether or not the request is a JSON request.
     *
     * @param object $request
     * @return bool
     */
    private function isJson($request)
    {
        return $request->wantsJson();
    }

    /**
     * Gets the view to be rendered based on the route object.
     *
     * @param object $route
     * @return View
     */
    private function actionView($route)
    {
        return View::make('some.view');
    }
}
