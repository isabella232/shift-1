<?php
namespace Tectonic\Shift\Modules\Localisation\Support;

use Exception;

trait Translatable
{
    /**
     * Stores the translations for each locale, field and value. Arrays look like so:
     *
     * ['en_GB' => ['field' => 'value']];
     *
     * @var array
     */
    private $translations = [];

    /**
     * Applies a given translation to the localised attributes on the entity.
     *
     * @param string $localeCode
     * @param string $field
     * @param string $value
     */
    public function applyTranslation($localeCode, $field, $value)
    {
        $translatableFields = $this->getLocalisedFields();

        if (!is_array($translatableFields)) {
            throw new Exception('getLocalisedFields() should return an array.');
        }

        if (in_array($field, $translatableFields)) {
            $this->translations[$localeCode][$field] = $value;
        }
    }

    /**
     * Should return an array containing the names of the fields that need to be localised.
     *
     * @return array
     */
	abstract public function getLocalisedFields();
}
 