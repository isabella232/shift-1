<?php namespace Tectonic\Shift\Modules\Localisation\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Localisation\Validators\LocalisationValidator;
use Tectonic\Shift\Modules\Localisation\Services\LocalisationManagementService;
use Tectonic\Shift\Modules\Localisation\Repositories\LocalisationRepositoryInterface;

class LocalisationController extends BaseController
{
    public function __construct(
        LocalisationRepositoryInterface $repository,
        LocalisationValidator $validator,
        LocalisationManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }
}