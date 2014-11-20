<?php
namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Config;
use Illuminate\Support\Collection;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

class ConfigLanguageRepository implements LanguageRepositoryInterface
{
    /**
     * Stores an array of all supported languages on the system.
     *
     * @var array
     */
    private static $languages;

    /**
     * @param Locale $locale
     */
    public function __construct()
    {
        if (!isset(static::$languages)) {
            static::$languages = $this->hydrateCollection(Config::get('shift::languages'));
        }
    }

    /**
     * Return all available languages.
     *
     * @return array
     */
    public function getAll()
    {
        return static::$languages;
    }

    /**
     * Retrieves a language based on its language code.
     *
     * @param string $code
     * @return Language
     */
    public function getByCode($code)
    {
        return new Language($code);
    }

    /**
     * Hydrates a collection object with a list of language objects.
     *
     * @param array $languages key-value pair array of language codes to language names.
     * @return Collection
     */
    private function hydrateCollection($languages)
    {
        $items = [];

        foreach ($languages as $code => $language) {
            $items[] = new Language($code);
        }

        return new Collection($items);
    }
}