<?php namespace Tectonic\Shift\Modules\Security\Validators;

use Tectonic\Shift\Library\Validation\Validation;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

class RoleValidation extends Validation
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService
     */
    private $currentAccountService;

    /**
     * We need to use the current account's id for future validation rules.
     *
     * @param CurrentAccountService $currentAccountService
     */
    public function __construct(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    /**
     * Return an array of validation rules to be applied to the role.
     *
     * @return array
     */
    public function getRules()
    {
        return [
            'name' => [
                'required',
                'unique:roles,name,id,account_id,'.$this->currentAccountService->getCurrentAccount()->id
            ]
        ];
    }
}
