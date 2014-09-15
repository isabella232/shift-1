<?php namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocalisationRepositoryInterface
{
    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  int   $localeId
     * @return array
     */
    public function getUILocalisations($localeId);
}