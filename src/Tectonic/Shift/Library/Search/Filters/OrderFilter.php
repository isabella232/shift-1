<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Tectonic\Shift\Library\Search\SearchFilter;
use Tectonic\Shift\Library\Contracts\SearchFilterInterface;

class OrderFilter extends SearchFilter implements SearchFilterInterface
{

	/**
	 * The default field for the search query to order by.
	 * 
	 * @var string
	 */
	public $defaultField = 'id';

	/**
	 * Default order direction.
	 * 
	 * @var string
	 */
	public $defaultDirection = 'DESC';
	
	/**
	 * Add an order by clause to the search query.
	 *
	 * @return OrderFilter
	 */
	public function criteria() {
		$this->query->orderBy($this->sortField());
		
		return $this;
	}
	
	/**
	 * Provides a default sort field if the order key is not present in the search params.
	 * 
	 * @return string 
	 */
	public function sortField() {
		return @$this->params['order'] ?: $this->defaultField;
	}

	/**
	 * Returns the required sort direction.
	 * 
	 * @return string
	 */
	public function sortDirection() {
		return @$this->params['direction'] ?: $this->defaultDirection;
	}

}