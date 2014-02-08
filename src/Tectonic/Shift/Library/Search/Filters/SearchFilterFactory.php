<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Event, Utility;
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
	public $search;

	/**
	 * Array housing all registered search filters.
	 * 
	 * @var array SearchFilterInterface
	 */
	public $filters = [];

	/**
	 * Registers the filters needed for this search method to function.
	 */
	public function __construct() 
	{
		$this->boot();
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
	 * Boots the search filter factory, and fires an event to see if any other packages or
	 * modules need to register filters for the search.
	 */
	public function boot() 
	{
		$this->register();
		
		$this->fireEvent($this->eventName(), [$this]);
	}

	/**
	 * Determines the event name to be fired when requiring other filters to be registered.
	 * 
	 * @return string
	 */
	protected function eventName() 
	{
		$class = str_replace('SearchFilterFactory', '', get_class($this));
		$base = substr(strtolower(preg_replace('/(A-Z)/', '.$1', $class)), 1);

		return Utility::eventName('search', $base, 'filters');
	}

	/**
	 * Called upon boot for child classes to register their required search filters and settings.
	 */
	abstract protected function register();
}