<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Localisation\Validators\LocalisationValidator;
use Tectonic\Shift\Modules\Localisation\Repositories\LocalisationRepositoryInterface;

class LocalisationManagementService extends BaseManagementService
{
    /**
     * @param LocalisationRepositoryInterface $repository
     * @param LocalisationValidator           $validator
     */
    public function __construct(LocalisationRepositoryInterface $repository, LocalisationValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}
