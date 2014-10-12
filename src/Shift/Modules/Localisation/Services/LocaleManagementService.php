<?php namespace Tectonic\Shift\Modules\Localisation\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;

class LocaleManagementService extends ManagementService
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

    /**
     * Get all resources
     *
     * @return mixed
     */
    public function getAll()
    {
        $resource = $this->repository->getLocales();

        return $resource;
    }
}
