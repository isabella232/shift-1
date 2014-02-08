<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Tectonic\Shift\Library\Contracts\SearchFilterInterface;
use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Traits\Observable;

abstract class SearchFilterFactory
{
	use Observable;

	/**
	 * Search engine search object.
	 * 
	 * @var SearchEngine
	 */
	protected $search;

	/**
	 * Array housing all registered search filters.
	 * 
	 * @var array SearchFilterInterface
	 */
	protected $filters = [];

	/**
	 * Registers the filters needed for this search method to function.
	 */
	public function __construct() 
	{
		$this->register();
		
		$this->fireEvent('filterFactoryBoot', [$this]);
	}

	/**
	 * Stores the search object locally.
	 * 
	 * @param SearchEngine $search
	 */
	public function setSearch(Search $search) 
	{
		$this->search = $search;
	}

	/**
	 * Registers a new search filter for this search.
	 * 
	 * @param  SearchFilter $filter
	 */
	public function addFilter(SearchFilterInterface $filter)
	{
		$filter->setSearch($this->search);
		
		$this->filters[] = $filter;
	}

	/**
	 * Returns the registered filters.
	 *
	 * @return array
	 */
	public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * Called upon boot for child classes to register their required search filters and settings.
	 */
	abstract protected function register();
}