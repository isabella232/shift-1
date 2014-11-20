<?php

namespace Tectonic\Shift\Library\Support\Database;

use Tectonic\Shift\Library\Search\SearchFilterCollection;

/**
 * Nearly all repositories will require the following methods. This is to ensure we're dealing with a 
 * common interface for all our repositories. Each repository should implement its own interface that extends
 * this, and if there are any changes in the requirements, they can define them there.
 */

interface RepositoryInterface
{
	/**
	 * Delete a specific resource. Returns the resource that was deleted.
	 *
	 * @param object $resource
	 * @param boolean $permanent
	 * @return Resource
	 */
	public function delete($resource, $permanent = false);

    /**
     * Returns a collection of all records for this repository and the models or entities it respresents.
     *
     * @return array
     */
    public function getAll();

	/**
	 * Create a resource based on the data provided.
	 *
     * @param array $data Optional
	 * @return Resource
	 */
	public function getNew(array $data = []);

	/**
	 * Acts as a generic method for retrieving a record by a given field/value pair.
	 *
	 * @param $field
	 * @param $value
	 * @return mixed
	 */
	public function getBy($field, $value);

    /**
     * Similar to getBy, but returns only a single record, rather than a collection of fields.
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function getOneBy($field, $value);

    /**
     * Acts as a generic method for requiring a record by a given field/value pair.
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function requireBy($field, $value);

	/**
	 * @param $resource
	 * @param array $data
	 * @return Resource
	 */
	public function update($resource, $data = []);

	/**
	 * Saves the provided resource.
	 *
	 * @param $resource
	 * @return mixed
	 */
	public function save($resource);

    /**
     * Retrieve a collection of results based on the search filters provided.
     *
     * @param SearchFilterCollection $filterCollection
     * @return mixed
     */
    public function getByFilters(SearchFilterCollection $filterCollection);

    /**
     * Save 1-n resources.
     *
     * @param $resources
     * @TODO: Utilise PHP 5.6 (make $resources an argument via variadic function argument syntax)
     * @return mixed
     */
    public function saveAll();
}