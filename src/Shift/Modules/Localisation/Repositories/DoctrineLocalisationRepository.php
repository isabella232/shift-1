<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Doctrine\ORM\EntityManager;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Entities\Localisation;

class DoctrineLocalisationRepository extends Repository implements LocalisationRepositoryInterface
{
    /**
     * Localisation entity
     *
     * @var \Tectonic\Shift\Modules\Localisation\Entities\Localisation
     */
    protected $entity = Localisation::class;

    /**
     * Locale repository
     *
     * @var \Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface
     */
    protected $localeRepo;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param LocaleRepositoryInterface $localeRepo
     * @throws \Tectonic\Shift\Library\Support\Database\Doctrine\EntityIsNullException
     */
    public function __construct(EntityManager $entityManager, LocaleRepositoryInterface $localeRepo)
    {
        parent::__construct($entityManager);

        $this->localeRepo = $localeRepo;
    }

    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  array $locales
     * @return array
     */
    public function getUILocalisations($locales)
    {
        $localeIds = $this->localeRepo->getLocaleIds($locales);

        $query = $this->entityManager()->createQueryBuilder()
            ->select(['l.field', 'l.value'])
            ->from($this->entity, 'l')
            ->where('l.resource = :resource')
            ->andWhere('l.locale_id IN (:locale_ids)')
            ->setParameter('resource', 'UI')
            ->setParameter('locale_ids', $localeIds);

        $results = $query->getQuery()->getArrayResult();

        return $this->flattenUILocalisations($results);
    }

    protected function flattenUILocalisations($results)
    {
        $array = [];

        foreach($results as $result)
        {
            $array[$result['field']] = $result['value'];
        }

        return $array;
    }
}