<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localisation\Services\LocaleManagementService;
use Tectonic\Shift\Modules\Localisation\Repositories\LocaleRepositoryInterface;

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
