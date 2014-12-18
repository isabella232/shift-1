<?php
namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Localisation\Translator\ResourceCriteria;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Models\Translation;

class EloquentTranslationRepository extends Repository implements TranslationRepositoryInterface
{
    /**
     * @param Translation $model
     */
    public function __construct(Translation $model)
    {
        $this->model = $model;
    }

    /**
     * When searching for translations to be applied to an entity, or a collection of entities,
     * we want to do so in the most manner possible. In this way, any repository you have
     * that searches for translations, should do so based on the ResourceCriteria object passed.
     *
     * @param ResourceCriteria $criteria
     * @return mixed
     */
    public function getByResourceCriteria(ResourceCriteria $criteria)
    {
        $resources = $criteria->getResources();
        $query = $this->getQuery();

        foreach ($resources as $resource) {
            $query->orWhere(function($query) use ($criteria, $resource) {
                $query->whereResource($resource);
                $query->whereIn('foreign_id', $criteria->getIds($resource));
            });
        }

        return $query->get();
    }

    /**
     * Retrieves all translations that match the required params.
     *
     * @param array $params
     * @return Collection
     */
    public function getByCriteria($params)
    {
        return $this->getByCriteriaQuery($params)->get();
    }

    /**
     * Same as getByCriteria, but only retrieves the first record.
     *
     * @param array $params
     * @return null|Translation
     */
    public function getOneByCriteria($params)
    {
        return $this->getByCriteriaQuery($params)->first();
    }

    /**
     * Returns a collection of translations based on the locale, the resource (such as ui) and the group.
     * The group represents a like query. Say for example you want all translations for roles, then the group
     * would be "roles", but the query created would be: WHERE field LIKE "roles.%"
     *
     * @param $locale
     * @param $resource
     * @param $group
     * @return mixed
     */
    public function getByGroup($locale, $resource, $group)
    {
        return $this->getQuery()
            ->whereAccountId(CurrentAccount::get()->id)
            ->whereLanguage($locale)
            ->whereResource($resource)
            ->where('field', 'LIKE', "{$group}.%")
            ->get();
    }

    /**
     * Generates the query builder object required for the get query requests.
     *
     * @param array $params
     * @return QueryBuilder
     */
    private function getByCriteriaQuery(array $params)
    {
        $query = $this->model->select(['*']);

        foreach ($params as $key => $value) {
            $query->where($key, '=', $value);
        }

        return $query;
    }

    /**
     * Find a translation/localisation for a given resource field
     *
     * @param string $language
     * @param string $resource
     * @param string $field
     * @param int    $foreignId
     *
     * @return array
     */
    public function findTranslation($language, $resource, $field, $foreignId)
    {
        return $this->getQuery()
            ->whereLanguage($language)
            ->whereResource($resource)
            ->whereForeignId($foreignId)
            ->whereField($field)
            ->first();
    }
}
