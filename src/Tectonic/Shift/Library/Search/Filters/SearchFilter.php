<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Tectonic\Shift\Library\Search\Search;

abstract class SearchFilter
{
	/**
	 * Stores the search params for the search query.
	 *
	 * @var array
	 */
	protected $params;

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
	public function params($key = null)
	{
		if (!is_null($key)) {
			return @$this->search->params[$key] ?: null;
		}

		return $this->search->params;
	}

	/**
	 * Shorthand method to retreive the search query object.
	 * 
	 * @return Query $query
	 */
	public function query()
	{
		return $this->search->query;
	}

	/**
	 * Must be implemented by children, contains the functionality required for registering
	 * the search criteria.
	 */
	abstract public function criteria();

}
