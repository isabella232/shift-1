<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localisation\Repositories\LocaleRepositoryInterface;

class LocaleManagementService extends BaseManagementService
{
    /**
     * @param LocaleRepositoryInterface $repository
     * @param LocaleValidator           $validator
     */
    public function __construct(LocaleRepositoryInterface $repository, LocaleValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}
