<?php
namespace Tectonic\Shift\Library\Localisation;

use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;

trait TranslatableValidations
{
    /**
     * Custom method to define required validations for translatable fields.
     *
     * @param string $fieldName
     */
    protected function requiredTranslation($fieldName)
    {
        $languages = CurrentAccount::get()->languages->lists('code');

        foreach ($languages as $code) {
            $this->rules["translated.$fieldName.$code"] = 'required';
        }
    }
}
