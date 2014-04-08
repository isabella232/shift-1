<?php

namespace Tectonic\Shift\Modules\Security\Search;

use Tectonic\Shift\Modules\Security\Models\Role;
use Tectonic\Shift\Modules\Security\Search\Filters\RoleSearchFilterFactory;

class RoleSearch extends \Tectonic\Shift\Library\Search\Search
{
	public function __construct(Role $role, RoleSearchFilterFactory $filterFactory)
	{
		$filterFactory->setSearch($this);
		
		$this->setQuery($role);
		$this->setFilters($filterFactory);
	}
}
