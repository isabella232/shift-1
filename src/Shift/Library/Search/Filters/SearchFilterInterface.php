<?php

namespace Tectonic\Shift\Library\Search\Filters;

interface SearchFilterInterface
{
    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return mixed
     */
    public function applyToEloquent($query);
}
