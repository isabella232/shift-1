<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use CurrentAccount;
use Tectonic\Application\Validation\Validator;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class CreateRoleValidator extends Validator
{
	public function getRules()
    {
        $this->requiredTranslation('name');

        return $this->rules;
    }

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
