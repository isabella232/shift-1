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
    private $code;

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
    }

    /**
     * Returns the language code for this instance.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the language string for the selected code.
     *
     * @return string
     */
    public function getLanguage()
    {
        return static::$languages[$this->code];
    }
}
