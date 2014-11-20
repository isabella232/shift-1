<?php
namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Localisation\Validators\TranslationValidator;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;

class TranslationManagementService extends ManagementService
{
    /**
     * @param TranslationRepositoryInterface $repository
     * @param TranslationValidator           $validator
     */
    public function __construct(TranslationRepositoryInterface $repository, TranslationValidator $validator)
    {
        $this->repository = $repository;
        $this->createValidator = $validator;
        $this->updateValidator = $validator;
    }
}
