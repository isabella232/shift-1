<?php
namespace Tectonic\Shift\Modules\Accounts\Commands;

use Tectonic\Application\Validation\Validator;

class CreateAccountValidator extends Validator
{
    protected $rules = [
        'name' => 'required',
        'defaultLanguageCode' => 'required',
        'domain' => 'required',
    ];
}
