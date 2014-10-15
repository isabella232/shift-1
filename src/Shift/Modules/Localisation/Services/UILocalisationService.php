<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationRepositoryInterface;

class UILocalisationService
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepo;

    /**
     * @var LocalisationRepositoryInterface
     */
    protected $localisationRepo;

    /**
     * @param LocaleRepositoryInterface $localeRepo
     * @param LocalisationRepositoryInterface $localisationRepo
     */
    public function __construct(LocaleRepositoryInterface $localeRepo, LocalisationRepositoryInterface $localisationRepo)
    {
        $this->localeRepo       = $localeRepo;
        $this->localisationRepo = $localisationRepo;
    }

    /**
     * Get UI Localisations
     *
     * @param array $locales
     * @return array
     */
    public function getUILocalisations(array $locales = [])
    {
        $localeIds = $this->localeRepo->getLocaleIds($locales);
        return $this->localisationRepo->getUILocalisations($localeIds);
    }

}