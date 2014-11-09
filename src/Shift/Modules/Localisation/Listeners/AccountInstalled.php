<?php
namespace Tectonic\Shift\Modules\Localisation\Listeners;

use Tectonic\Shift\Library\Support\Listener;
use Tectonic\Shift\Modules\Accounts\Services\SupportedLanguageManagementService;

class AccountInstalled extends Listener
{
    /**
     * @var SupportedLanguageManagementService
     */
    private $supportedLanguages;

    /**
     * @param SupportedLanguageManagementService $supportedLanguages
     */
    public function __construct(SupportedLanguageManagementService $supportedLanguages)
    {
        $this->supportedLanguages = $supportedLanguages;
    }

    /**
     * @return array
     */
    public function hooks()
    {
        return [
            'account.installed' => 'addLanguage'
        ];
    }

    /**
     * @param $account
     */
    public function addLanguage($account, $input)
    {
        $supportedLanguageInput = [
            'languageId' => $input['language'],
            'accountId' => $account->getId()
        ];

        $this->supportedLanguages->create($supportedLanguageInput);
    }
}
 
