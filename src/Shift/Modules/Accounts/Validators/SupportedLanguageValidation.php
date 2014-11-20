<?php
namespace Tectonic\Shift\Modules\Accounts\Validators;

use Tectonic\Application\Validation\Validator;

class SupportedLanguageValidation extends Validator
{
    public function getRules()
    {
        return [
            'accountId' => 'required',
            'languageId' => 'required',
        ];
    }
}
