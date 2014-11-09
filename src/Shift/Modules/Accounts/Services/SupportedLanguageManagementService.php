<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Validators\SupportedLanguageValidation;

class SupportedLanguageManagementService extends ManagementService
{
    /**
     * @param LanguageRepositoryInterface $languageRepository
     * @param SupportedLanguageRepositoryInterface $supportedLanguageRepository
     */
    public function __construct(
        SupportedLanguageRepositoryInterface $supportedLanguageRepository,
        SupportedLanguageValidation $validator
    ) {
        $this->repository = $supportedLanguageRepository;
        $this->createValidator = $validator;
        $this->updateValidator = $validator;
    }
}
