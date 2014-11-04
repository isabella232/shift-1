<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface TranslationInterface
{
    /**
     * @return mixed
     */
    public function getField();

    /**
     * @return integer
     */
    public function getForeignId();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return LanguageInterface
     */
    public function getLanguage();

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $field
     * @return void
     */
    public function setField($field);

    /**
     * @param string $resource
     * @return void
     */
    public function setResource($resource);

    /**
     * @param string $value
     * @return void
     */
    public function setValue($value);

    /**
     * @param LanguageInterface $locale
     * @return void
     */
    public function setLanguage(LanguageInterface $language);

    /**
     * Creates a new localisation instance.
     *
     * @param LanguageInterface $language
     * @param $resource
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function add(LanguageInterface $language, $resource, $field, $value);
}
 