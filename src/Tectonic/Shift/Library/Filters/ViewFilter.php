<?php

namespace Tectonic\Shift\Library\Filters;

use Request;
use View;
use Tectonic\Shift\Library\Utility;

class ViewFilter
{
	const STATUS_NOT_ALLOWED = 405;

	/**
	 * Stores the Utility object.
	 *
	 * @var Utility
	 */
	public $utility;

	public function __construct(Utility $utility)
	{
		$this->utility = $utility;
	}

	public function filter()
	{
		return $this->utility->noJsonView();
	}
}
