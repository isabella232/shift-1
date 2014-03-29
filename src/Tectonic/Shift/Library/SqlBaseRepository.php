<?php

namespace Tectonic\Shift\Library;

use Tectonic\Shift\Library\Contracts\BaseRepositoryInterface;

abstract class SqlBaseRepository implements BaseRepositoryInterface
{
	/**
	 * Stores the model object for querying.
	 *
	 * @var Eloquent
	 */
	public $model;

	/**
	 * Stores the validator object that should be used for all validations via the repository.
	 *
	 * @var ValidatorInterface
	 */
	public $validator;
	
	/**
	 * Stores the search object used by the resource.
	 *
	 * @var Search
	 */
	public $search;

	/**
	 * Get a specific resource.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function findById($id)
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Create a resource based on the data provided.
	 *
	 * @return Resource
	 */
	public function create()
	{
		return $this->model->newInstance();
	}

	/**
	 * Delete a specific resource. Returns the resource that was deleted.
	 *
	 * @param object $resource
	 * @param boolean $permanent
	 * @return Resource
	 */
	public function delete($resource, $permanent = false)
	{
		if ($permanent) {
			$resource->forceDelete();
		}
		else {
			$resource->delete();
		}

		return $resource;
	}

	/**
	 * Update a resource based on the id and data provided.
	 *
	 * @param object $resource
	 * @param array $data
	 * @return Resource
	 */
	public function update($resource, $data = [])
	{
		if (is_array($data) && count($data) > 0) {
			$resource->fill($data);
		}

		$resource->save();

		return $resource;
	}
}
