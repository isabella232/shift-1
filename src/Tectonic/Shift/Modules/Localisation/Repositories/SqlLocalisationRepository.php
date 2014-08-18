<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\Localisation\Models\Localisation;

class SqlLocalisationRepository extends SqlBaseRepository implements LocalisationRepositoryInterface
{
    public function __construct(Localisation $localisation)
    {
        $this->model = $localisation;
    }

    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @return array
     */
    public function getUILocalisations($localeId)
    {
        return $this->model
            ->where('resource', '=', '')
            ->where('locale_id', '=', $localeId)
            ->lists('value', 'field');
    }

}
