<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Localisation\Validators\LocalisationValidator;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;

class LocalisationManagementService extends ManagementService
{
    /**
     * @param LocalisationRepositoryInterface $repository
     * @param LocalisationValidator           $validator
     */
    public function __construct(TranslationRepositoryInterface $repository, LocalisationValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}
