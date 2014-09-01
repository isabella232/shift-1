<?php namespace Tectonic\Shift\Library\Support;

/**
 * Class BaseManagementService
 *
 * The purpose of this class is to provide all management
 * services with a common set of methods/functionality for
 * performing operations such as; Create, Read, Update & Delete.
 *
 * @package Tectonic\Shift\Library\Support
 */
abstract class BaseManagementService
{
    /**
     * Stores the repository that will handle the
     * @var
     */
    protected $repository;

    protected $validator;

    /**
     * Create a new resource
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create($data)
    {
        $this->validator
            ->setInput($data)
            ->forMethod('create')
            ->validate();

        $resource = $this->repository->getNew($data);

        return $this->repository->save($resource);
    }

    /**
     * Get a specified resource
     *
     * @param int $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->repository->requireById($id);
    }

    /**
     * Update a specified resource
     *
     * @param int $id
     * @param array $input
     *
     * @return mixed
     */
    public function update($id, $input)
    {
        $resource = $this->repository->requireById($id);

        $this->validator->setInput($input)
            ->forMethod('update')
            ->using($resource)
            ->validate();

        return $this->repository->update($resource, $input);
    }

    /**
     * Delete a specified resource
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $resource = $this->repository->requireById($id);

        return $this->repository->delete($resource);
    }
}
