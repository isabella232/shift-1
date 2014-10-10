<?php namespace Tectonic\Shift\Controllers;

use JMS\Serializer\SerializerBuilder;
use Response;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleValidator;
use Tectonic\Shift\Modules\Localisation\Services\LocaleManagementService;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface;

class LocaleController extends Controller
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

    public function getIndex()
    {
        $resources = $this->crudService->getAll();

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        return json_encode($resources);
        return $serializer->serialize($resources, 'json');
    }

}
