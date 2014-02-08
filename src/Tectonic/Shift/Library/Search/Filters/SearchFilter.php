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
	 * @param SearchEngine $search
	 */
	public function setSearch(Search $search)
	{
		$this->search = $search;
	}

	/**
	 * Sets the params object on the class.
	 *
	 * @param string $key
	 * @return array
	 */
	public function getParams($key = null)
	{
		$params = $this->search->getParams();

		if (!is_null($key)) {
			return @$params[$key];
		}

		return $params;
	}

	/**
	 * Shorthand method to retreive the search query object.
	 * 
	 * @return Query $query
	 */
	public function getQuery()
	{
		return $this->search->query;
	}
}
