<?php

namespace Tectonic\Shift\Modules\Security\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\Filters\SearchFilterFactory;

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
