<?php
namespace Tectonic\Shift\Modules\Installation\Commands;

use Tectonic\Application\Validation\Validator;

class InstallShiftValidator extends Validator
{
    protected $rules = [
        'name'     => 'required',
        'host'     => 'required',
        'email'    => 'required',
        'password' => 'required',
    ];
}
