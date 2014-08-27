<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\Localisation\Models\Localisation;

class SqlLocalisationRepository extends SqlBaseRepository implements LocalisationRepositoryInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepo;

    public function __construct(Localisation $localisation, LocaleRepositoryInterface $localeRepo)
    {
        $this->model = $localisation;
        $this->localeRepo = $localeRepo;
    }

    /**
     * Return a key/value paired array of UI localisations/customisations
     *
     * @param  $locales
     * @return array
     */
    public function getUILocalisations($locales)
    {
        $localeIds = $this->localeRepo->getLocaleIds($locales);

        return $this->model
            ->where('resource', '=', '')
            ->whereIn('locale_id', $localeIds)
            ->lists('value', 'field');
    }

}
