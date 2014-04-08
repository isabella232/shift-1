<?php

namespace Tectonic\Shift\Modules\Security\Search;

use Tectonic\Shift\Security\Models\Role;
use Tectonic\Shift\Security\Search\Filters\RoleSearchFilterFactory;

class RoleSearch extends \Tectonic\Shift\Core\Search\Search
{
	public function __construct(Role $role, RoleSearchFilterFactory $filterFactory)
	{
		$filterFactory->setSearch($this);
		
		$this->setQuery($role);
		$this->setFilterFactory($filterFactory);
	}
}
