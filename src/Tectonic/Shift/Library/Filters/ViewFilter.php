<?php

namespace Tectonic\Shift\Core\Filters;

use Request;
use View;
use Utility;

class ViewFilter
{
	const STATUS_NOT_ALLOWED = 405;

	public function filter()
	{
		return Utility::noJsonView();
	}
}
