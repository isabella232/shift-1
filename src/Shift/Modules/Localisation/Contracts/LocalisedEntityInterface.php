<?php
namespace Tectonic\Shift\Modules\Localisation\Contracts;

interface LocalisedEntityInterface
{
    /**
     * Should return an array containing the names of the fields that need to be localised.
     *
     * @return array
     */
    public function getLocalisedFields();
}
