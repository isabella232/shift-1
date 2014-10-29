<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Localisation\Validators\LocalisationValidator;
use Tectonic\Shift\Modules\Localisation\Services\LocalisationManagementService;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;

class LocalisationController extends Controller
{
    public function __construct(
        TranslationRepositoryInterface $repository,
        LocalisationValidator $validator,
        LocalisationManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }
}