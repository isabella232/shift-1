<?php
namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Doctrine\ORM\EntityManager;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Models\Translation;
use Tectonic\Shift\Modules\Localisation\Support\ResourceCriteria;

class EloquentTranslationRepository extends Repository implements TranslationRepositoryInterface
{
    /**
     * Locale repository
     *
     * @var \Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface
     */
    protected $languageRepository;

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
    public function __construct(Translation $translation, LanguageRepositoryInterface $localeRepository)
    {
        $this->languageRepository = $localeRepository;
        $this->model = $translation;
    }

    /**
     * Return a key/value paired array of UI translations.
     *
     * @param  array $locales
     * @return array
     */
    public function getUITranslations(array $locales)
    {
        $localeIds = $this->languageRepository->getLanguageIds($locales);

        $results = $this->getQuery()
            ->whereResource('UI')
            ->whereIn('locale_id', $localeIds)
            ->lists('field', 'value');

        return $this->flattenUITranslations($results);
    }

    /**
     * Find a translation for a given resource field
     *
     * @param int    $foreignId
     * @param string $resource
     * @param string $field
     * @param string $languageId
     *
     * @return array
     */
    public function findTranslation($foreignId, $resource, $field, $languageId)
    {
        $localeId = $this->languageRepository->getLanguageId($languageId);

        return $this->getQuery()
            ->whereForeignId($foreignId)
            ->whereResource($resource)
            ->whereField($field)
            ->whereLanguageId($localeId)
            ->first();
    }

    protected function flattenUITranslations($results)
    {
        $array = [];

        foreach ($results as $result) {
            $array[$result['field']] = $result['value'];
        }

        return $array;
    }

    /**
     * Returns a collection of localisations based on the resource criteria.
     *
     * @param ResourceCriteria $criteria
     * @return mixed
     */
    public function getByResourceCriteria(ResourceCriteria $criteria)
    {
        $resources = $criteria->getResources();
        $query = $this->getQuery()->with(['language']);

        foreach ($resources as $resource) {
            $query ->orWhere(function($query) use ($criteria, $resource) {
                $query->whereResource($resource);
                $query->whereIn('foreignId', $criteria->getIds($resource));
            });
        }

        return $query->get();
    }
}