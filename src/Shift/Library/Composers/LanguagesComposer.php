<?php
namespace Tectonic\Shift\Library\Composers;

use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;

class LanguagesComposer
{
    /**
     * @var LanguageRepositoryInterface
     */
    private $languages;

    /**
     * @param LanguageRepositoryInterface $languages
     */
    public function __construct(LanguageRepositoryInterface $languages)
    {
        $this->languages = $languages;
    }

    /**
     * Sets up the languages collection to be used by the iew.
     *
     * @param $view
     */
    public function compose($view)
    {
        $view->languages = $this->languages->getAll();
    }
}
