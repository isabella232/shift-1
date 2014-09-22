<?php

namespace Tectonic\Shift\Library\Search\Filters;

interface SearchFilterInterface
{
	/**
	 * Applies the filter's requirements to the doctrine query builder.
	 *
	 * @param $queryBuilder
	 * @return mixed
	 */
	public function applyToDoctrine($queryBuilder);
}
