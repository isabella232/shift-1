<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;

interface LocalisationRepositoryInterface
{
    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  array $locales
     * @return array
     */
    public function getUILocalisations(array $locales);

    /**
     * Returns a collection of localisations based on the resource criteria.
     *
     * @param ResourceCriteria $criteria
     * @return mixed
     */
    public function getByResourceCriteria(ResourceCriteria $criteria);
}