<?php namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocalisationRepositoryInterface
{
    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  array $locales
     * @return array
     */
    public function getUILocalisations($locales);
}