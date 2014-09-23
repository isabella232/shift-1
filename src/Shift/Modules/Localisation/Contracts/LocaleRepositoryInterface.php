<?php namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocaleRepositoryInterface
{
    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLocaleIds($locales);

    /**
     * Get the ID of a locale by it's code ('en-GB')
     *
     * @param  string $localeCode
     * @return int
     */
    public function getLocaleId($localeCode);

    /**
     * Get the Code of a locale from it's ID
     *
     * @param  int    $localeId
     * @return string
     */
    public function getLocaleCode($localeId);
}
