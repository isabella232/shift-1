<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LanguageInterface
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
    public function getLanguage();

    /**
     * @param string $code
     * @return void
     */
    public function setCode($code);

    /**
     * @param string $language
     * @return void
     */
    public function setLanguage($language);

    /**
     * Creates a new LanguageInterface instance.
     *
     * @param string $language
     * @param string $code
     * @return mixed
     */
    public static function add($language, $code);
}
 