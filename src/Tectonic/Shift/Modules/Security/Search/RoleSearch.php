<?php

namespace Tectonic\Shift\Modules\Security\Search;

use Tectonic\Shift\Modules\Security\Models\Role;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;

class RoleSearch extends \Tectonic\Shift\Library\Search\Search
{
	private $keywordFilter;

	private $orderFilter;

	public function __construct(Role $role, KeywordFilter $keywordFilter, OrderFilter $orderFilter)
	{
		$this->setQuery($role);

		$this->keywordFilter = $keywordFilter;
		$this->orderFilter = $orderFilter;

		$this->registerFilters();
	}

	public function registerFilters()
	{
		$this->addFilter($this->keywordFilter);
		$this->addFilter($this->orderFilter);
	}
}
