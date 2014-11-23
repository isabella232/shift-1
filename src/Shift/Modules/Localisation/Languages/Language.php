<?php
namespace Tectonic\Shift\Modules\Localisation\Languages;

use Config;
use Tectonic\Shift\Modules\Localisation\UnsupportedLanguageException;

class Language
{
    /**
     * Stores the languages that are supported by the system.
     *
     * @var array
     */
    private static $languages;

    /**
     * The language code.
     *
     * @var string
     */
    public $code;

    /**
     * The full, readable version of the language.
     *
     * @var string
     */
    public $language;

    /**
     * Create a new language instance, based on the language code provided.
     *
     * @param string $code
     * @throws UnsupportedLanguageException
     */
    public function __construct($code)
    {
        if (!isset(static::$languages)) {
            static::$languages = Config::get('shift::languages');
        }

        if (!array_key_exists($code, static::$languages)) {
            throw new UnsupportedLanguageException($code);
        }

        $this->code = $code;
        $this->language = static::$languages[$code];
    }
}
