<?php
namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Modules\Localisation\Models\Language;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;

class EloquentLanguageRepository extends Repository implements LanguageRepositoryInterface
{
    /**
     * Locales are not restricted by account. They're an application-wide root data structure.
     *
     * @var bool
     */
    public $restrictByAccount = false;

    /**
     * @param Locale $locale
     */
    public function __construct(Language $locale)
    {
        $this->model = $locale;
    }

    /**
     * Creates a new locale instance.
     *
     * @param array $input
     */
    public function getNew(array $input = [])
    {
        return Language::add($input['language'], $input['code']);
    }

    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLanguageIds($locales)
    {
        $localeIds = [];

        foreach ($locales as $locale) {
            $localeIds[] = $this->getLanguageId($locale);
        }

        return $localeIds;
    }

    /**
     * Get the ID of a locale by it's code ('en_GB')
     *
     * @param  string $languageCode
     * @return int
     */
    public function getLanguageId($languageCode)
    {
        return $this->getQuery()->whereCode($languageCode)->pluck('id');
    }

    /**
     * Get the Code of a locale from it's ID
     *
     * @param int $languageId
     * @return string
     */
    public function getLanguageCode($languageId)
    {
        return $this->getQuery()->whereId($languageId)->pluck('code');
    }
}