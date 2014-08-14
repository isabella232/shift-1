<?php namespace Tectonic\Shift\Modules\Localization\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Localization\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localization\Services\LocaleManagementService;
use Tectonic\Shift\Modules\Localization\Repositories\LocaleRepositoryInterface;

class LocaleController extends BaseController
{

    public function __construct(
        LocaleRepositoryInterface $repository,
        LocaleValidator $validator,
        LocaleManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }

}
