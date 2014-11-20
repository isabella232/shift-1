<?php
namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;

class Localiser
{
    /**
     * @var LocalisationRepositoryInterface
     */
    protected $translationRepository;

    /**
     * @param LocalisationRepositoryInterface $repository
     */
    public function __construct(TranslationRepositoryInterface $repository)
    {
        $this->translationRepository = $repository;
    }

    /**
     * Localise a resource
     *
     * This method accepts a resource, an array of fields that need localising,
     * and the locale code for required translations. It will look at each field, and try and find a translation
     * for that field for that resource. This results in the resource having the translated values, rather
     * than the original values that were saved.
     *
     * @param mixed $resource
     * @param array $fields
     * @param string $locale
     *
     * @return mixed
     */
    public function localise($resource, array $fields, $locale)
    {
        $id   = $resource->id;
        $name = $this->getResourceName($resource);

        foreach ($fields as $field) {
            $translation = $this->translationRepository->findTranslation($id, $name, $field, $locale);

            if (!is_null($translation)) {
                $resource->$field = $translation['value'];
            }
        }

        return $resource;
    }

    /**
     * Localise a collection of resources
     *
     * @param  mixed  $collection
     * @param  array  $fields
     * @param  string $locale
     * @return mixed
     */
    public function localiseCollection($collection, array $fields, $locale)
    {
        foreach ($collection as $resource) {
            $this->localise($resource, $fields, $locale);
        }

        return $collection;
    }

    /**
     * Find the full-qualified class name of a resource
     *
     * @param  mixed  $resource
     * @return string
     */
    public function getResourceName($resource)
    {
        return class_basename($resource);
    }

    /**
     * Gets translations for a given set of resources.
     *
     * @param array $resources
     * @throws \Exception
     */
    public function getTranslationsByResources(array $resources) {
        $resourceCriteria = new ResourceCriteria;

        foreach ($resources as $resource => $ids) {
            $resourceCriteria->addResource($resource);

            foreach ($ids as $id) {
                $resourceCriteria->addId($resource, $id);
            }
        }

        return $this->translationRepository->getByResourceCriteria($resourceCriteria);
    }
}