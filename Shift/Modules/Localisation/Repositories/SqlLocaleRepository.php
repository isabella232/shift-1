<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\Localisation\Models\Locale;
use Tectonic\Shift\Modules\Localisation\Support\LocaleTranslatorInterface;

class SqlLocaleRepository extends SqlBaseRepository implements LocaleRepositoryInterface, LocaleTranslatorInterface
{
    public function __construct(Locale $locale)
    {
        $this->model = $locale;
    }

    /**
     * Translate the ID from the locales database table
     * in to it's 4-digit locale code.
     *
     * @param int $id
     * @return string
     */
    public function getCode($id)
    {
        $result = $this->model->where('id', '=', $id)->first(['code']);

        return $result->code;
    }

    /**
     * Translate 4-digit locale code in to the ID from the
     * locales database table.
     *
     * @param  string $code
     * @return int
     */
    public function getId($code)
    {
        $result = $this->model->where('code', '=', $code)->first(['id']);

        return $result->id;
    }


    /**
     * Get the ID's of passed in locales codes
     *
     * @param  array $locales
     * @return array
     */
    public function getLocaleIds($locales)
    {
        return $this->model->whereIn('code', $locales)->lists('id');
    }
}
