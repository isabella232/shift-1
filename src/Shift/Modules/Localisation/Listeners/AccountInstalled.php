<?php
namespace Tectonic\Shift\Modules\Localisation\Listeners;

use Tectonic\Shift\Library\Support\Listener;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Services\SupportedLanguagesService;

class AccountInstalled extends Listener
{
    /**
     * @var SupportedLanguagesService
     */
    private $supportedLanguages;

    /**
     * @param SupportedLanguagesService $supportedLanguages
     */
    public function __construct(SupportedLanguagesService $supportedLanguages)
    {
        $this->supportedLanguages = $supportedLanguages;
    }

    /**
     * @return array
     */
    public function hooks()
    {
        return [
            'account.installed' => 'associateLocale'
        ];
    }

    /**
     * Adds the selected language as a supported language for the new account.
     *
     * @param AccountInterface $account
     * @param array $input
     */
    public function assignLanguage(AccountInterface $account, array $input)
    {
        $this->supportedLanguages->addToAccount($input['language'], $account->getId());
    }
}
