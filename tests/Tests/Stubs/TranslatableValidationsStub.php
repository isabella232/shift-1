<?php
namespace Tests\Stubs;

use Tectonic\Shift\Library\Localisation\TranslatableValidations;

class TranslatableValidationsStub
{
	use TranslatableValidations;

    public $rules = [];

    public function required($field)
    {
        $this->requiredTranslation($field);

        return $this->rules;
    }
}
