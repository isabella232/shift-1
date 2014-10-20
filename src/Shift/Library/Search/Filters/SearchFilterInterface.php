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

    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return mixed
     */
    public function applyToEloquent($query);
}
