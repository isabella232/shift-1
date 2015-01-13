<?php

namespace Tectonic\Shift\Library\Search\Filters;

class OrderFilter implements SearchFilterInterface
{
	/**
	 * The default field to be used for sorting.
	 *
	 * @var string
     */
	protected $defaultField = 'id';

	/**
	 * The default field for the search query to order by.
	 * 
	 * @var string
	 */
	protected $field = null;

	/**
	 * Default order direction.
	 * 
	 * @var string
	 */
	protected $direction = null;

	/**
	 * @param string $field
	 * @param string $direction
	 */
	protected function __construct($field, $direction)
	{
		$this->field = $field;
		$this->direction = $direction;
	}

	/**
	 * Create a new order filter from a syntax-friendly static method.
	 *
	 * @param string $field
	 * @param string $direction
	 */
	public static function byFieldAndDirection($field, $direction)
	{
		return new static($field, $direction);
	}

	/**
	 * We can also filter from a more generic, unknown array. Here, the OrderFilter will be a bit smarter
	 * and apply ordering conditions based on the input available.
	 *
	 * @param array $input
	 */
	public static function byInput(array $input = [])
	{
		$field = array_get($input, 'order');
		$direction = isset($input['direction']) ? $input['direction'] : 'desc';

		return static::byFieldAndDirection($field, $direction);
	}

    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return mixed
     */
    public function applyToEloquent($query)
    {
        return $query->orderBy($this->sortField(), $this->sortDirection());
    }

	/**
	 * Returns the required sort direction.
	 * 
	 * @return string
	 */
	protected function sortDirection()
	{
		$validDirections = ['ASC', 'DESC'];
		$direction = strtoupper($this->direction);

		if (!in_array($direction, $validDirections)) {
			throw new \Exception("$direction is not a valid direction for SQL querying. Use either ASC or DESC.");
		}

		return $direction;
	}

	/**
	 * Set the default field for ordering.
	 *
	 * @param $field
     */
	public function setDefaultField($field)
	{
		$this->defaultField = $field;
	}

	/**
	 * If no cusotm field has been specified, use the default.
	 *
	 * @return string
     */
	protected function sortField()
	{
		return $this->field ?: $this->defaultField;
	}
}