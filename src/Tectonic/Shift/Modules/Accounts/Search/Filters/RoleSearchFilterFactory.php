<?php

namespace Tectonic\Shift\Accounts\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;

class RoleSearchFilterFactory extends \Tectonic\Shift\Library\Search\Filters\SearchFilterFactory
{
	public function __construct(KeywordFilter $keywordFilter, OrderFilter $orderFilter)
	{
		$this->keywordFilter = $keywordFilter;
		$this->orderFilter = $orderFilter;

		parent::__construct();
	}

	public function register()
	{
		$this->addFilter($this->keywordFilter);
		$this->addFilter($this->orderFilter);
	}
}
