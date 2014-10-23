<?php
namespace Tectonic\Shift\Modules\Localisation\Support\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisedEntityInterface;
use Tectonic\Shift\Modules\Localisation\Services\Localiser;
use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;

/**
 * Class ModelLocalisationTransformer
 *
 * Works on an entity or collection of entities to retrieve the various resources that need
 * to be localised, and then does a second pass through the entity/collection and attaches these
 * localised fields and values to the entity.
 *
 * @TODO: Currently this is Eloquent-only, and needs to be refactored to support any kind of model
 * or entity or collection.
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
     * A multidimensional array where the key is the name of the resource, and the child array
     * consists of each of the model ids that need to be found within the localisation table.
     *
     * @var array
     */
    private $resourcesRequired = [];

    /**
     * Stores the resource criteria object which is used for localisation queries.
     *
     * @var ResourceCriteria
     */
    private $resourceCriteria;

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
        if ($model instanceof LocalisedEntityInterface) {
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
    }

    protected function getLocalisedValuesForResources()
    {
        $this->localisationRepository->getByResourcesArray();
    }
}
