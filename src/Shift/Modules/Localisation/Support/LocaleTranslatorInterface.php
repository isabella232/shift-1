<?php namespace Tectonic\Shift\Modules\Localisation\Support;

interface LocaleTranslatorInterface
{
    /**
     * Translate the ID from the locales database table
     * in to it's 4-digit locale code.
     *
     * @param int $id
     * @return string
     */
    public function getCode($id);

    /**
     * Translate 4-digit locale code in to the ID from the
     * locales database table.
     *
     * @param string $code
     * @return int
     */
    public function getId($code);
}