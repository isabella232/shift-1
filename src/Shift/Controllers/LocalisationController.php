<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Localisation\Validators\TranslationValidator;
use Tectonic\Shift\Modules\Localisation\Services\TranslationManagementService;

class LocalisationController extends Controller
{
    public function __construct(
        TranslationValidator $validator,
        TranslationManagementService $service
    ) {
        $this->validator   = $validator;
        $this->crudService = $service;
    }
}