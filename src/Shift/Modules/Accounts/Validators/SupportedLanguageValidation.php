<?php
namespace Tectonic\Shift\Modules\Accounts\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class SupportedLanguageValidation extends Validation
{
    public function getRules()
    {
        return [
            'accountId' => 'required',
            'languageId' => 'required',
        ];
    }
}
