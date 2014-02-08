<?php

namespace Tectonic\Shift\Library\Search\Filters;

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
	public function criteria()
	{
		$this->getQuery()->orderBy($this->sortField(), $this->sortDirection());
		
		return $this;
	}
	
	/**
	 * Provides a default sort field if the order key is not present in the search params.
	 * 
	 * @return string 
	 */
	protected function sortField()
	{
		return @$this->getParam('order') ?: $this->defaultField;
	}

	/**
	 * Returns the required sort direction.
	 * 
	 * @return string
	 */
	protected function sortDirection()
	{
		$validDirections = ['ASC', 'DESC'];

		if ($this->hasParam('direction')) {
			$direction = strtoupper($this->getParam('direction'));

			if (in_array($direction, $validDirections)) {
				return $direction;
			}
		}

		return $this->defaultDirection;
	}

}