<?php
namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Accounts\Models\SupportedLanguage;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageInterface;

class EloquentSupportedLanguagesRepository extends Repository implements SupportedLanguagesRepositoryInterface
{
    /**
     * @param SupportedLanguage $model
     */
    public function __construct(SupportedLanguage $model)
    {
        $this->model = $model;
    }

    /**
     * Add a new supported language to the system for the current account.
     *
     * @param $language
     * @return Resource
     */
    public function add(LanguageInterface $language)
    {
        $supportedLanguage = $this->getNew();
        $supportedLanguage->languageId = $language->getId();

        return $this->save($supportedLanguage);
    }
}
