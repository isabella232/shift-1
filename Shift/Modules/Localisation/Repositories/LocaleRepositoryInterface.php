<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\BaseRepositoryInterface;

interface LocaleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLocaleIds($locales);
}
