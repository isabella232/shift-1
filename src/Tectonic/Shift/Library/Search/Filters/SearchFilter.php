<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Tectonic\Shift\Library\Search\Search;

class SearchFilter
{
	/**
	 * Stores the search object in question.
	 * 
	 * @var Search
	 */
	protected $search;

	/**
	 * Set the search engine that will be used for this filter.
	 * 
	 * @param Search $search
	 */
	public function setSearch(Search $search)
	{
		$this->search = $search;
	}

	/**
	 * Any call to the search filter, we basically just want to forward onto the search class,
	 * which contains all the methods we need for filtering :)
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array([$this->search, $method], $arguments);
	}
}
