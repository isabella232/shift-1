<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocalisationInterface
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
     * @return LocaleInterface
     */
    public function getLocale();

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
     * @param LocaleInterface $locale
     * @return void
     */
    public function setLocale(LocaleInterface $locale);

    /**
     * Creates a new localisation instance.
     *
     * @param LocaleInterface $locale
     * @param $resource
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function add(LocaleInterface $locale, $resource, $field, $value);
}
 