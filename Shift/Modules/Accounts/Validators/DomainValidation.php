<?php

namespace Tectonic\Shift\Modules\Accounts\Validators;

use Illuminate\Support\Facades\Validator;
use Tectonic\Shift\Library\Validation\Validation;

class DomainValidation extends Validation
{
    /**
     * Custom messages for domain validation.
     *
     * @var array
     */
    protected $messages = [
        'domainFormat' => 'Domain name is invalid.'
    ];

    /**
     * We need a custom validator, so domain rules must be specified
     * as part of the getRules method.
     *
     * @return array
     */
    public function getRules()
    {
        Validator::extend('domainFormat', function($field, $value) {
            return preg_match('/^([a-z0-9]+\.)?([a-z0-9\-]+)\.([a-z]{2,3})$/i', $value);
        });

        $id = $this->getInput('id');
        $uniquenessValidator = 'unique:domains,domain'.($id ? ':'.$id : '');

        $rules = [
            'domain' => ['required', 'domainFormat', $uniquenessValidator]
        ];

        return $rules;
    }
}
