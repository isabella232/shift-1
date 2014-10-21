<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocaleInterface
{
    /**
     * @return string
     */
    public function getCode();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @param string $code
     * @return void
     */
    public function setCode($code);

    /**
     * @param string $locale
     * @return void
     */
    public function setLocale($locale);

    /**
     * Creates a new LocaleInterface instance.
     *
     * @param string $locale
     * @param string $code
     * @return mixed
     */
    public static function add($locale, $code);
}
 