<?php

namespace Tectonic\Shift\Library\Contracts;

/**
 * Nearly all repositories will require the following methods. This is to ensure we're dealing with a 
 * common interface for all our repositories. Each repository should implement its own interface that extends
 * this, and if there are any changes in the requirements, they can define them there.
 */

interface BaseRepositoryInterface
{
	/**
	 * Get all resources.
	 *
	 * @return [Resource]
	 */
	public function all();

	/**
	 * Search for resources based on the key-value params provided.
	 *
	 * @param array $params
	 * @return array
	 */
	public function search($params);

	/**
	 * Get a specific resource.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function find($id);

	/**
	 * Delete a specific resource. Returns the resource that was deleted.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function delete($id);

	/**
	 * Create a resource based on the data provided.
	 *
	 * @param array $data
	 * @return Resource
	 */
	public function create($data);

	/**
	 * Update a resource based on the id and data provided.
	 *
	 * @param integer $id
	 * @param array $data
	 * @return Resource
	 */
	public function update($id, $data);
}