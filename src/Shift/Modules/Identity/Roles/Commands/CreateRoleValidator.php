<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use CurrentAccount;
use Tectonic\Application\Validation\Validator;

class CreateRoleValidator extends Validator
{
	public function getRules()
    {
        $fields = (new Role)->getTranslatableFields();
        $languages = CurrentAccount::get()->languages->lists('code');

        foreach ($fields as $field) {
            foreach ($languages as $code) {
                $rules["translated.$field.$code"] = 'required';
            }
        }
    }
}
