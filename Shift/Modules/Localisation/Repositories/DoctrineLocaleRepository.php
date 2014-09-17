<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Modules\Localisation\Entities\Locale;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;

class DoctrineLocaleRepository extends Repository implements LocaleRepositoryInterface
{
    protected $entity = Locale::class;

    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLocaleIds($locales)
    {
        $localeIds = [];

        foreach($locales as $locale)
        {
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
        $query = $this->entityManager()->createQueryBuilder()
            ->select('l')
            ->from($this->entity, 'l')
            ->where('l.code = :code')
            ->setParameter('code', $localeCode);

        $result = $query->getQuery()->getSingleResult();

        return $result->getId();
    }

    /**
     * Get the Code of a locale from it's ID
     *
     * @param int $localeId
     * @return string
     */
    public function getLocaleCode($localeId)
    {
        $query = $this->entityManager()->createQuery()
            ->select($this->entity . ' locales')
            ->where("locales.code = ':id'")
            ->setParameter('id', $localeId);

        $result = $query->getSingleResult();

        return $result->getCode();
    }
}