<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;

class SupportedLanguagesService
{
    /**
     * @var LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @var SupportedLanguageRepositoryInterface
     */
    private $supportedLanguageRepository;

    /**
     * @param LanguageRepositoryInterface $languageRepository
     * @param SupportedLanguageRepositoryInterface $supportedLanguageRepository
     */
    public function __construct(
        LanguageRepositoryInterface $languageRepository,
        SupportedLanguageRepositoryInterface $supportedLanguageRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->supportedLanguageRepository = $supportedLanguageRepository;
    }

    /**
     * Adds a new supported language to the account.
     *
     * @param $language
     */
    public function add($languageId)
    {
        $language = $this->languageRepository->getById($languageId);

        return $this->supportedLanguageRepository->add($language);
    }

    /**
     * Removes a language by the language id.
     *
     * @param $account
     * @param $language
     */
    public function remove($languageId)
    {
        $language = $this->languageRepository->getById($languageId);

        return $this->supportedLanguageRepository->remove($language);
    }

    /**
     * Adds a new supported language to a specific account.
     *
     * @param $languageId
     * @param $accountId
     * @return mixed
     */
    public function addToAccount($languageId, $accountId)
    {
        $supportedLanguage = $this->supportedLanguageRepository->getNew([], true);
        $supportedLanguage->languageId = $languageId;
        $supportedLanguage->accountId = $accountId;

        return $this->supportedLanguageRepository->save($supportedLanguage);
    }
}
 