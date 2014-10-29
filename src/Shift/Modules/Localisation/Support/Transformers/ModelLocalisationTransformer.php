<?php
namespace Tectonic\Shift\Modules\Localisation\Support\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Services\Localiser;
use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;
use Tectonic\Shift\Modules\Localisation\Support\Translatable;

/**
 * Class ModelLocalisationTransformer
 *
 * Works on an entity or collection of entities to retrieve the various resources that need
 * to be localised, and then does a second pass through the entity/collection and attaches these
 * localised fields and values to the entity.
 *
 * @TODO: Currently this is Eloquent-only, and needs to be refactored to support any kind of model
 * or entity or collection (such as elasticsearch or doctrine, or caching..etc.)
 *
 * @package Tectonic\Shift\Modules\Localisation\Support\Transformers
 */
class ModelLocalisationTransformer
{
    /**
     * The localiser provides some base level functionality for dealing with localising.
     *
     * @var Localiser
     */
    private $localiser;

    /**
     * Stores the resource criteria object which is used for localisation queries.
     *
     * @var ResourceCriteria
     */
    private $resourceCriteria;

    /**
     * Stores the collection of resources once fetched from the repository.
     *
     * @var collection
     */
    private $resources;

    /**
     * @param Localiser $localiser
     */
    public function __construct(Localiser $localiser, ResourceCriteria $resourceCriteria)
    {
        $this->localiser = $localiser;
        $this->resourceCriteria = $resourceCriteria;
    }

    /**
     * Localises a given collection of models.
     *
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this->getResourcesFromCollection($collection);
        $this->applyLocalisationToCollection($collection);
    }

    /**
     * Localises a specific model.
     *
     * @param Model $model
     */
    public function model(Model $model)
    {
        $this->getResourcesFromModel($model);
        $this->applyLocalisationToModel($model);
    }

    /**
     * Loops through each of the collection items, and gets the resources for each model.
     *
     * @param Collection $collection
     */
    protected function getResourcesFromCollection(Collection $collection)
    {
        foreach ($collection as $model) {
            $this->getResourcesFromModel($model);
        }
    }

    /**
     * Retrieves the model's class name, and the id.
     *
     * @param Model $model
     */
    protected function getResourcesFromModel(Model $model)
    {
        if ($model instanceof Translatable) {
            $this->recordResources($model);
        }
    }

    /**
     * Records the resources from a given model.
     *
     * @param Model $model
     */
    protected function recordResources(Model $model)
    {
        $resourceName = $this->localiser->getResourceName($model);

        $this->resourceCriteria->addResource($resourceName);
        $this->resourceCriteria->addId($resourceName, $model->getId());

        // Now loop through each of the eagerly loaded relations, and get the resources from them as well
        foreach ($model->getRelations() as $relation) {
            $this->getResourcesFromCollection($relation);
        }
    }

    /**
     * Retrieves the localised fields and values for the required resources and associated ids.
     *
     * @returns collection
     */
    protected function getLocalisedValuesForResources()
    {
        if (!is_null($this->resources)) {
            $this->resources = $this->localisationRepository->getByResourceCriteria($this->resourceCriteria);
        }

        return $this->resources;
    }

    /**
     * Applies the localised values/translations already found, to a given collection.
     *
     * @param $collection
     */
    public function applyLocalisationToCollection($collection)
    {
        foreach ($collection as $model) {
            if ($model instanceof Translatable) {
                $this->applyLocalisationToModel($model);
            }
        }
    }

    /**
     * Sets a model's localised fields based on the records found earlier.
     *
     * @param $model
     */
    public function applyLocalisationToModel(Model $model)
    {
        $resourceName = $this->localiser->getResourceName($model);
        $localisedResource = $this->findResource($resourceName, $model->id);

        // apply localised resources to the model
        if ($localisedResource) {
            $model->applyTranslation(
                $localisedResource->getLocale()->getCode(),
                $localisedResource->getField(),
                $localisedResource->getValue()
            );
        }

        // If the model has any eagerly loaded relations, also apply localisations to them
        foreach ($model->getRelations() as $relation) {
            $this->applyLocalisationToCollection($relation);
        }
    }

    /**
     * Searches the fetched resources for a given resource and id, and returns the associated object.
     *
     * @param string $resource
     * @param integer $id
     * @return mixed
     */
    protected function findResource($resource, $id)
    {
        foreach ($this->resourceas as $r) {
            if ($r->resource == $resource && $r->id = $id) {
                return $r;
            }
        }
    }
}
