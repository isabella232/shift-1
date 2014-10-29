<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;

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
    public function __construct(LanguageRepositoryInterface $localeRepo, TranslationRepositoryInterface $localisationRepo)
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
        $localeIds = $this->localeRepo->getLanguageIds($locales);
        return $this->localisationRepo->getUITranslations($localeIds);
    }

}