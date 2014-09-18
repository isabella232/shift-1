<?php

namespace Tectonic\Shift\Library\Search;

interface SearchRepositoryInterface
{
	/**
	 * Implementations should search the data store using the criteria collection provided.
	 *
	 * @param SearchFilterCollection $filters
	 * @return mixed
	 */
	public function getByCriteria(SearchFilterCollection $filters);
}
