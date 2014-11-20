<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LanguageRepositoryInterface
{
    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLanguageIds($locales);

    /**
     * Get the ID of a locale by it's code ('en-GB')
     *
     * @param  string $languageCode
     * @return int
     */
    public function getLanguageId($languageCode);

    /**
     * Get the Code of a locale from it's ID
     *
     * @param  int    $languageId
     * @return string
     */
    public function getLanguageCode($languageId);

    /**
     * Retrieves a language based on its language code.
     *
     * @param string $languageCode
     * @return mixed
     */
    public function getOneByLanguageCode($languageCode);
}
