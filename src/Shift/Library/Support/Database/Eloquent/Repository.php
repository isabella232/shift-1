<?php
namespace Tectonic\Shift\Library\Support\Database\Eloquent;

use CurrentAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Tectonic\Localisation\Contracts\TranslatableInterface;
use Tectonic\Localisation\Translator\Translatable;
use Tectonic\Shift\Library\Search\SearchFilterCollection;
use Tectonic\Shift\Library\Support\Database\RepositoryInterface;
use Tectonic\Shift\Library\Support\Exceptions\MethodNotFoundException;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

abstract class Repository implements RepositoryInterface
{
    /**
     * Many resources within shift may be restricted by the account the user is assigned to (if applicable).
     * As a result, resources can
     *
     * @var bool
     */
    protected $restrictByAccount = true;

    /**
     * Stores the model object for querying.
     *
     * @var Eloquent
     */
    protected $model;

    /**
     * Returns a collection of all records for this repository and the models or entities it respresents.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->getQuery()->all();
    }

    /**
     * Acts as a generic method for retrieving a record by a given field/value pair.
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function getBy($field, $value)
    {
        return $this->getByQuery($field, $value)->get();
    }

    /**
     * Retrieves a single record based on the field and value provided.
     *
     * @param $field
     * @param $value
     * @return null
     */
    public function getOneBy($field, $value)
    {
        return $this->getByQuery($field, $value)->first();
    }

    /**
     * Returns a single record based on the slug string.
     *
     * @param string $slug
     */
    public function getBySlug($slug)
    {
        return $this->requireBy('slug', $slug);
    }

    /**
     * Creates a query object used for getBy and getOneBy methods. This is particularly handy for models
     * that have translatable fields. In short, it allows the developer to easily query for model objects
     * that may have fields that reside within the translations table.
     *
     * @param $field
     * @param $value
     * @return QueryBuilder
     */
    protected function getByQuery($field, $value)
    {
        $model = $this->model;
        $translatableFields = $this->getTranslatableFields($this->model);

        // If the model is translatable, and the field exists within the array, as well as the model having a
        // translations relationship defined on the model, we can do some neat stuff querying for a field value.
        if (in_array($field, $translatableFields) && method_exists($model, 'translations')) {
            return $this->getQuery()->whereHas('translations', function($query) use ($field, $value, $model) {
                $query->where('resource', '', class_basename($model));
                $query->where('field', '=', $field);
                $query->where('value', 'like', "%{$value}%");
            });
        }
        else {
            return $this->getQuery()->where($field, '=', $value);
        }
    }

    /**
     * Returns a single record based on id.
     *
     * @param $id
     * @return null
     */
    public function getById($id)
    {
        $model = $this->getBy('id', $id);

        if (!$model->isEmpty()) {
            return $model[0];
        }

        return null;
    }

    /**
     * Retrieve a collection of results based on the search filters provided.
     *
     * @param SearchFilterCollection $filterCollection
     * @param boolean $paginate
     * @return mixed
     */
    public function getByFilters(SearchFilterCollection $filterCollection, $paginate = true)
    {
        $query = $this->getQuery();

        foreach ($filterCollection as $filter) {
            $filter->applyToEloquent($query);
        }

        if ($paginate) {
            return $query->paginate();
        }

        return $query->get();
    }

    /**
     * Save 1-n resources.
     *
     * @param array $resources
     * @return mixed
     */
    public function saveAll(...$resources)
    {
        if (count($resources) == 0) {
            throw new Exception('You must provide at least one $resource argument.');
        }

        foreach ($resources as $resource) {
            $this->save($resource);
        }
    }

    /**
     * Searches for a resource with the field and value provided. If no resource is found that matches
     * the value, then it will throw a ModelNotFoundException.
     *
     * @param string $field
     * @param string $value
     * @return Eloquent
     * @throws ModelNotFoundException
     */
    public function requireBy($field, $value)
    {
        $result = $this->getBy($field, $value);

        if (!$result) {
            throw with(new ModelNotFoundException)->setModel(get_class($this->model));
        }

        return $result[0];
    }

    /**
     * Returns the model that is being used by the repository.
     *
     * @return Eloquent
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Create a resource based on the data provided.
     *
     * @param array $data
     *
     * @return Resource
     */
    public function getNew(array $data = [])
    {
        $model = $this->model->newInstance($data);

        return $model;
    }

    /**
     * Returns a new query object that can be used.
     *
     * @return mixed
     */
    protected function getQuery()
    {
        $query = $this->model->newInstance();

        if ($this->restrictByAccount) {
            $query->whereAccountId($this->currentAccountId());
        }

        return $query;
    }

    /**
     * Sets the model to be used by the repository.
     *
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
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
            $resource->fill($data);
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
        $attributes = $resource->getDirty();

        if (!$resource->exists && $this->restrictByAccount && !$resource->accountId) {
            $resource->accountId = $this->currentAccountId();
        }

        if (!empty($attributes) || !$resource->exists) {
            return $resource->save();
        }

        return $resource->touch();
    }

    /**
     * A single method to return the currentAccountId. This is the account id that represents
     * the current request's account, domain.etc.
     *
     * @return integer
     */
    protected function currentAccountId()
    {
        return CurrentAccount::get()->id;
    }

    /**
     * Determines the translatable fields available on the model assigned to the repository.
     *
     * @param Model $model
     * @return bool
     */
    protected function getTranslatableFields(Model $model)
    {
        return $model instanceof TranslatableInterface ? $model->getTranslatableFields() : [];
    }

    /**
     * The repository supports magic method calls to getBy* where the * equates to a valid
     * field name on the entity. Eg:
     *
     * $repository->getByFieldName('value') would create a new query and try and find records
     * based on the field 'fieldName'
     *
     * @param string $method
     * @param array $arguments
     * @return Resource
     * @throws MethodNotFoundException
     */
    public function __call($method, $arguments)
    {
        // Handles method calls for basic queries like getById or requireById
        foreach (['getBy', 'requireBy'] as $queryType) {
            if (strstr($method, $queryType)) {
                $field = Str::camel(str_replace($queryType, '', $method));
                $value = $arguments[0];

                return $this->$queryType($field, $value);
            }
        }

        throw new MethodNotFoundException($this, $method);
    }
}
