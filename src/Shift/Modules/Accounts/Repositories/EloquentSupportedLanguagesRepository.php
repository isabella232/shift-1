<?php
namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\SupportedLanguage;

class EloquentSupportedLanguagesRepository extends Repository implements SupportedLanguageRepositoryInterface
{
    /**
     * @param SupportedLanguage $model
     */
    public function __construct(SupportedLanguage $model)
    {
        $this->model = $model;
    }
}
