<?php
namespace Tectonic\Shift\Library\Search\Filters;

class IncludeFilter implements SearchFilterInterface
{
    /**
     * Stores the relationships that should be included as part of the search results.
     *
     * @var array
     */
    private $relationships;

    /**
     * @param ...$relationships
     */
    public function __construct(...$relationships)
    {
        $this->relationships = $relationships;
    }

    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param object $query
     * @return mixed
     */
    public function applyToEloquent($query)
    {
        return $query->with($this->relationships);
    }
}
