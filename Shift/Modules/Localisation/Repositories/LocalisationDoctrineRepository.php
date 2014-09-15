<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationRepositoryInterface;

class LocalisationDoctrineRepository extends Repository implements LocalisationRepositoryInterface
{
    /**
     * @param  int   $localeId
     * @return array
     */
    public function getUILocalisations($localeId)
    {
        // TODO: Implement getUILocalisations() method.
    }
}