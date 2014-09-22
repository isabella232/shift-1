<?php

namespace Tectonic\Shift\Library\Search;

use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;

class SearchFilterCollection implements \Iterator
{
	/** An array of search filters.
	 *
	 * @var array SearchFilterInterface
	 */
	private $filters = [];

	/**
	 * Construct our search filter collection, ready for filters!
	 */
	public function __construct()
	{
		$this->rewind();
	}

	/**
	 * Return the current value at the array position.
	 *
	 * @return mixed
	 */
	public function current()
	{
		return $this->filters[$this->position];
	}

	/**
	 * Return the current array position.
	 *
	 * @return mixed
	 */
	public function key()
	{
		return $this->position;
	}

	/**
	 * Iterate through the filters array by one.
	 *
	 * @return void
	 */
	public function next()
	{
		++$this->position;
	}

	/**
	 * Reset the internal array pointer to the start of the filters collection.
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->position = 0;
	}

	/**
	 * Determines whether or not the current position in the array is valid.
	 *
	 * @return bool
	 */
	public function valid()
	{
		return isset($this->filters[$this->position]);
	}

	/**
	 * Add a new filter to the filter collection.
	 *
	 * @param SearchFilterInterface $filter
	 * @return void
	 */
	public function add(SearchFilterInterface $filter)
	{
		$this->filters[] = $filter;
	}
}
