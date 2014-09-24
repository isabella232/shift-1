<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaliserInterface;

class Localiser implements LocaliserInterface
{
    /**
     * @var LocalisationRepositoryInterface
     */
    protected $repository;

    /**
     * @param LocalisationRepositoryInterface $repository
     */
    public function __construct(LocalisationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Localise a resource
     *
     * This method accepts a resource, an array of fields that need localising,
     * and the locale code for required translations.
     *
     * @param mixed $resource
     * @param array $fields
     * @param string $locale
     *
     * @return mixed
     */
    public function localise($resource, $fields, $locale)
    {
        $id   = $this->getResourceId($resource);
        $name = $this->getResourceName($resource);

        foreach($fields as $field)
        {
            $translation = $this->repository->findTranslation($id, $name, $field, $locale);

            if(!is_null($translation))
            {
                $resource->{'set'.$field}($translation['value']);
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
    public function localiseCollection($collection, $fields, $locale)
    {
        foreach($collection as $resource)
        {
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
    private function getResourceName($resource)
    {
        return get_class($resource);
    }

    /**
     * Get the resource ID (primary key)
     *
     * @param  mixed $resource
     * @return int
     */
    private function getResourceId($resource)
    {
        return $resource->getId();
    }
}