<?php namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocaliserInterface
{
    /**
     * Localise a resource
     *
     * This method accepts a resource, an array of fields that need localising,
     * and the locale code for required translations. It will return the same
     * back again, with update field value - if localisations exist.
     *
     * @param mixed $resource
     * @param array $fields
     * @param string $locale
     *
     * @return mixed
     */
    public function localise($resource, $fields, $locale);

    /**
     * Localise a collection of resources
     *
     * This method accepts a collection of resources, an array of fields to be localised,
     * and the locale code for required translations. It will return the same collection
     * back again, with update field values on each resource - if localisations exist.
     *
     * @param  mixed $collection
     * @param  array $fields
     * @param  string $locale
     * @return mixed
     */
    public function localiseCollection($collection, $fields, $locale);
}