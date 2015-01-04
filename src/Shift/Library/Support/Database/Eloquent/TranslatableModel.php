<?php
namespace Tectonic\Shift\Library\Support\Database\Eloquent;

use CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Models\Translation;

trait TranslatableModel
{
    /**
     * Defines the translations relationship for a given model.
     *
     * @return Relation
     */
    public function translations()
    {
        return $this->hasMany(Translation::class, 'foreign_id')->where('resource', '=', class_basename($this));
    }

    /**
     * Add a translation for a given language, field and value for the current model.
     *
     * @param string $language
     * @param string $field
     * @param string $value
     *
     * @return \Tectonic\LaravelLocalisation\Database\Translation
     * @throws \Exception
     */
    public function addTranslation($language, $field, $value)
    {
        if (!$this->id) {
            throw new \Exception('Addition of translations can only be done once a model has been saved.');
        }

        $translation = new Translation(compact('language', 'field', 'value'));
        $translation->account_id = CurrentAccount::get()->id;
        $translation->resource = class_basename($this);
        $translation->foreign_id = $this->id;

        $this->translations()->save($translation);
    }
}
 