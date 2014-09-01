<?php namespace Tectonic\Shift\Library\Support\Database\Doctrine;

use Doctrine\ORM\EntityRepository;
use Tectonic\Shift\Library\Support\BaseRepositoryInterface;
use Tectonic\Shift\Library\Support\Database\RecordNotFoundException;

abstract class DoctrineBaseRepository extends EntityRepository implements BaseRepositoryInterface
{
    /**
     * Stores the entity manager object for querying.
     *
     * @var
     */
    protected $entityManager = null;

    /**
     * The entity that this repository will use for the base level queries.
     *
     * @var string null
     */
    protected $entity = null;

    /**
     * Some simple validation on the class implementation.
     */
    public function __construct()
    {
        if (is_null($this->entity)) {
            throw new EntityIsNullException;
        }
    }

    /**
     * Returns the entity manager used but will throw an EntityNotFoundException if
     * no entity has been specified by a child implementation.
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Get a specific resource.
     *
     * @param integer $id
     *
     * @return Resource
     */
    public function getById($id)
    {
        return $this->getEntity()->find($this->entity, $id);
    }

    /**
     * Searches for a resource with the id provided. If no resource is found that matches
     * the $id value, then it will throw a ModelNotFoundException.
     *
     * @param $id
     *
     * @return Resource
     * @throws ModelNotFoundException
     */
    public function requireById($id)
    {
        $model = $this->getById($id);
        
        if (!$model) {
            throw with(new RecordNotFoundException($this->entity, $id))->setModel(get_class($this->model));
        }

        return $model;
    }

    /**
     * Returns the entity that is being used by the repository.
     *
     * @return Eloquent
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Create a resource based on the data provided.
     *
     * @param array $data
     * @return Resource
     */
    public function getNew(array $data = [])
    {
        $entity = (new $this->entity);

        if ($data) {
            $this->decorate($entity, $data);
        }

        return $entity;
    }

    /**
     * Delete a specific resource. Returns the resource that was deleted.
     *
     * @param object  $resource
     * @param boolean $permanent
     *
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
     * @param array  $data
     *
     * @return Resource
     */
    public function update($resource, $data = [])
    {
        if (is_array($data) && count($data) > 0) {
            $this->decorate($resource, $data);
        }

        $this->save($resource);

        return $resource;
    }

    /**
     * Saves the resource provided to the database.
     *
     * @param $resource
     *
     * @return Resource
     */
    public function save($resource)
    {
        $this->getEntity()->persist($resource);
        $this->getEntity()->flush();
    }

    /**
     * Used to decorate a resoruce with the required data for persisting.
     *
     * @param $resource
     * @param $data
     * @return mixed
     */
    private function decorate($resource, $data)
    {
        foreach ($data as $key => $value) {
            $resource->{'set'.$key}($value);
        }

        return $resource;
    }
}
