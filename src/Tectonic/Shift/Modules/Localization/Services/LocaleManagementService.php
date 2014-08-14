<?php namespace Tectonic\Shift\Modules\Localization\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Localization\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localization\Repositories\LocaleRepositoryInterface;

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
