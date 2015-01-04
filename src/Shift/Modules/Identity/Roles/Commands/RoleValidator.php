<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Validation\Validator;
use Tectonic\Shift\Library\Localisation\TranslatableValidations;

class RoleValidator extends Validator
{
    use TranslatableValidations;

    public function getRules()
    {
        $this->requiredTranslation('name');

        return $this->rules;
    }
}
