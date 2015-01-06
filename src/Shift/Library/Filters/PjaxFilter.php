<?php
namespace Tectonic\Shift\Library\Filters;

use Request;
use Tectonic\Shift\Library\Traits\Respondable;

/**
 * Class PjaxFilter
 *
 * The PJAX filter has one task only - to check to see if the request is pjax, and if so - make
 * sure that the URL provided that should be added to the pushstate, is the right one.
 *
 * @package Tectonic\Shift\Library\Filters
 */
class PjaxFilter
{
    use Respondable;

	public function filter($route, $request, $response)
    {
        if ($this->isPjax()) {
            $response->header('X-PJAX-URL', Request::url());
        }
    }
}
