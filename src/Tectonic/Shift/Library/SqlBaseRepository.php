<?php

namespace Tectonic\Shift\Library;

abstract class SqlBaseRepository implements BaseRepositoryInterface
{
	/**
	 * Stores the model object for querying.
	 *
	 * @var Eloquent
	 */
	public $model;
	
	/**
	 * Stores the search object used by the resource.
	 *
	 * @var Search
	 */
	public $search;

	/**
	 * Get all models.
	 *
	 * @return [$this->model]
	 */
	public function all()
	{
		return $this->model->all();
	}

	/**
	 * Search for resources based on the key-value params provided.
	 *
	 * @param array $params
	 * @return array
	 */
	public function search($params)
	{
		$this->search->setParams($params);

		return $this->search->results();
	}

	/**
	 * Get a specific resource.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Delete a specific resource. Returns the resource that was deleted.
	 *
	 * @param integer $id
	 * @return Resource
	 */
	public function delete($id)
	{
		$resource = $this->find($id);

		$resource->delete();

		return $resource;
	}

	/**
	 * Create a resource based on the data provided.
	 *
	 * @param array $data
	 * @return Resource
	 */
	public function create($data)
	{
		$resource = $this->model->create($data);

		return $resource;
	}

	/**
	 * Update a resource based on the id and data provided.
	 *
	 * @param integer $id
	 * @param array $data
	 * @return Resource
	 */
	public function update($id, $data)
	{
		$resource = $this->find($id);

		$resource->fill($data);
		$resource->save();

		return $resource;
	}
}
