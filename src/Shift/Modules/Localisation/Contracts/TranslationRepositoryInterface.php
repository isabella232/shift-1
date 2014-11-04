<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;

interface TranslationRepositoryInterface
{
    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  array $locales
     * @return array
     */
    public function getUITranslations(array $locales);

    /**
     * Returns a collection of translations based on the resource criteria.
     *
     * @param ResourceCriteria $criteria
     * @return mixed
     */
    public function getByResourceCriteria(ResourceCriteria $criteria);
}