<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Localisation\Validators\TranslationValidator;
use Tectonic\Shift\Modules\Localisation\Services\TranslationManagementService;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;

class LocalisationController extends Controller
{
    public function __construct(
        TranslationRepositoryInterface $repository,
        TranslationValidator $validator,
        TranslationManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }
}