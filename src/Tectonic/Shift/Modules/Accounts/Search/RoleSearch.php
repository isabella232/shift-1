<?php

namespace Tectonic\Shift\Modules\Accounts\Search;

use Tectonic\Shift\Core\Search\SearchEngine;
use Tectonic\Shift\Roles\Role;
use Tectonic\Shift\Roles\Search\Filters\RoleSearchFilterFactory;

class RoleSearch extends \Tectonic\Shift\Core\Search\Search
{
	public function __construct(Role $role, RoleSearchFilterFactory $filterFactory)
	{
		$filters->setSearch($this);
		
		$this->setQuery($role);
		$this->setFilterFactory($filterFactory);
	}
}
