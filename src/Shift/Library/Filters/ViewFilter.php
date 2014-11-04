<?php
namespace Tectonic\Shift\Library\Filters;

use Request;
use View;

class ViewFilter
{
	public function filter()
	{
        if (!Request::wantsJson()) {
            return View::make('shift::layouts.application');
        }
	}
}
