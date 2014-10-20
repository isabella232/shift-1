<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Modules\Localisation\Models\Locale;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;

class EloquentLocaleRepository extends Repository implements LocaleRepositoryInterface
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
    public function __construct(Locale $locale) {
        $this->model = $locale;
    }

    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLocaleIds($locales)
    {
        $localeIds = [];

        foreach ($locales as $locale) {
            $localeIds[] = $this->getLocaleId($locale);
        }

        return $localeIds;
    }

    /**
     * Get the ID of a locale by it's code ('en_GB')
     *
     * @param  string $localeCode
     * @return int
     */
    public function getLocaleId($localeCode)
    {
        return $this->getQuery()->whereCode($localeCode)->pluck('id');
    }

    /**
     * Get the Code of a locale from it's ID
     *
     * @param int $localeId
     * @return string
     */
    public function getLocaleCode($localeId)
    {
        return $this->getQuery()->whereId($localeId)->pluck('code');
    }

    /**
     * Get all locales
     *
     * @return mixed
     */
    public function getLocales()
    {
        $query = $this->createQuery();
        return $query->getQuery()->getResult();
    }
}