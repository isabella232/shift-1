<?php
namespace Tectonic\Shift\Modules\Localisation\Listeners;

use Tectonic\Shift\Library\Support\Listener;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Services\SupportedLanguageManagementService;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Services\TranslationsService;

class AccountInstalled extends Listener
{
    /**
     * @var SupportedLanguageManagementService
     */
    private $supportedLanguages;
    /**
     * @var TranslationsService
     */
    private $translations;

    /**
     * @var LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @param SupportedLanguageManagementService $supportedLanguages
     */
    public function __construct(
        SupportedLanguageManagementService $supportedLanguages,
        TranslationsService $translations,
        LanguageRepositoryInterface $languageRepository
    ) {
        $this->supportedLanguages = $supportedLanguages;
        $this->translations = $translations;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return array
     */
    public function hooks()
    {
        return [
            'account.installed' => 'addLanguage',
            'account.installed' => 'addNameTranslation',
        ];
    }

    /**
     * Adds/registers the selected language for the installed account.
     *
     * @param AccountInterface $account
     * @param array $input
     */
    public function addLanguage(AccountInterface $account, array $input)
    {
        $supportedLanguageInput = [
            'languageId' => $input['language'],
            'accountId' => $account->getId()
        ];

        $this->supportedLanguages->create($supportedLanguageInput);
    }

    /**
     * Accounts require a name that is translated into 1 or more languages. This method handles that
     * requirement for the account installation process.
     *
     * @param AccountInterface $account
     * @param array $input
     */
    public function addNameTranslation(AccountInterface $account, array $input)
    {
        $language = $this->languageRepository->getById($input['language']);

        $this->translations->add($account, $language->getCode(), 'name', $input['name']);
    }
}
 
