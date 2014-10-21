<?php
namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Doctrine\ORM\EntityManager;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Models\Localisation;

class EloquentLocalisationRepository extends Repository implements LocalisationRepositoryInterface
{
    /**
     * Locale repository
     *
     * @var \Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * Account wide data root. No need to restrict queries by account.
     *
     * @var bool
     */
    public $restrictByAccount = false;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param LocaleRepositoryInterface $localeRepository
     * @throws \Tectonic\Shift\Library\Support\Database\Doctrine\EntityIsNullException
     */
    public function __construct(Localisation $localisation, LocaleRepositoryInterface $localeRepository)
    {
        $this->localeRepository = $localeRepository;
        $this->model = $localisation;
    }

    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  array $locales
     * @return array
     */
    public function getUILocalisations(array $locales)
    {
        $localeIds = $this->localeRepository->getLocaleIds($locales);

        $results = $this->getQuery()
            ->whereResource('UI')
            ->whereIn('locale_id', $localeIds)
            ->lists('field', 'value');

        return $this->flattenUILocalisations($results);
    }

    /**
     * Find a translation/localisation for a given resource field
     *
     * @param int    $foreignId
     * @param string $resource
     * @param string $field
     * @param string $locale
     *
     * @return array
     */
    public function findTranslation($foreignId, $resource, $field, $locale)
    {
        $localeId = $this->localeRepository->getLocaleId($locale);

        return $this->getQuery()
            ->whereForeignId($foreignId)
            ->whereResource($resource)
            ->whereField($field)
            ->whereLocaleId($localeId)
            ->first();
    }

    protected function flattenUILocalisations($results)
    {
        $array = [];

        foreach ($results as $result) {
            $array[$result['field']] = $result['value'];
        }

        return $array;
    }
}