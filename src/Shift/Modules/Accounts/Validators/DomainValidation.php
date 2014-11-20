<?php
namespace Tectonic\Shift\Modules\Accounts\Validators;

use Illuminate\Support\Facades\Validator;

class DomainValidation extends \Tectonic\Application\Validation\Validator
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
            $domainValidation = '([a-z0-9]+\.)?([a-z0-9\-]+)\.([a-z]{2,3})';
            $ipPortValidation = '([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})(:[0-9]{2,5})?';

            return preg_match("/^(($domainValidation)|($ipPortValidation))$/i", $value);
        });

        $rules = [
            'domain' => ['required', 'domainFormat', 'unique:domains,domain,'.$this->getValue('id')]
        ];

        return $rules;
    }
}
