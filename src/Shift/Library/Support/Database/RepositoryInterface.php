<?php

namespace Tectonic\Shift\Library\Support\Database;

/**
 * Nearly all repositories will require the following methods. This is to ensure we're dealing with a 
 * common interface for all our repositories. Each repository should implement its own interface that extends
 * this, and if there are any changes in the requirements, they can define them there.
 */

interface RepositoryInterface
{
	/**
	 * Create a resource based on the data provided.
	 *
     * @param array $data Optional
	 * @return Resource
	 */
	public function getNew(array $data = []);

	/**
	 * Delete a specific resource. Returns the resource that was deleted.
	 *
	 * @param object $resource
	 * @param boolean $permanent
	 * @return Resource
	 */
	public function delete($resource, $permanent = false);

	/**
	 * Get a specific resource.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function getById($id);

	/**
	 * Similar to getById, but should raise an EntityNotFoundException.
	 *
	 * @param $id
	 * @return mixed
	 */
	public function requireById($id);

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
     * Save 1-n resources.
     *
     * @param $resources
     * @return mixed
     */
    public function saveAll(...$resources);
}