<?php

namespace Tectonic\Shift\Library\Support;

use App;
use Event;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

/**
 * Class BaseManagementService
 *
 * The purpose of this class is to provide all management
 * services with a common set of methods/functionality for
 * performing operations such as; Create, Read, Update & Delete.
 *
 * @package Tectonic\Shift\Library\Support
 */

abstract class ManagementService
{
    /**
     * Stores the repository that will handle the
     * @var
     */
    protected $repository;

	/**
	 * Validation class used for resource creation.
	 *
	 * @var
	 */
	protected $createValidator;

	/**
	 * Validation class used for resource updates.
	 *
	 * @var
	 */
	protected $updateValidator;

    /**
     * Create a new resource
     *
     * @param array $input
     * @return mixed
     * @fires Model.created
     */
    public function create($input)
    {
        $this->createValidator->setInput($input)->validate();

        $resource = $this->repository->getNew($input);

	    $this->repository->save($resource);

	    $this->notify('created', $resource);
	    $this->notify('saved', $resource);

        return $resource;
    }

    /**
     * Get a specified resource
     *
     * @param int $id
     * @return mixed
     * @fires Model.retrieved
     */
    public function get($id)
    {
        $resource = $this->repository->requireById($id);

	    $this->notify('retrieved', $resource);

	    return $resource;
    }

    /**
     * Update a specified resource
     *
     * @param int $id
     * @param array $input
     * @return mixed
     * @fires Model.updated
     */
    public function update($id, $input)
    {
        $resource = $this->repository->requireById($id);

	    $this->updateValidator->setInput($input)->validate();

        $this->repository->update($resource, $input);

	    $this->notify('updated', $resource);
	    $this->notify('saved', $resource);

	    return $resource;
    }

    /**
     * Delete a specified resource
     *
     * @param int $id
     * @return mixed
     * @fires Model.deleted
     */
    public function delete($id)
    {
        $resource = $this->repository->requireById($id);

        $this->repository->delete($resource);
		$this->notify('deleted', $resource);

	    return $resource;
    }

    /**
     * Fires an event for the resource based on the event and resource.
     *
     * @param $event
     * @param $resource
     */
    public function notify($event, $resource)
	{
		Event::fire(class_basename($resource).'.'.$event, [$resource]);
	}
}
