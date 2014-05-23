<?php namespace Tectonic\Shift\Modules\CustomFields\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\CustomFields\Services\CustomFieldManagementService;

class CustomFieldController extends BaseController
{

    public function __construct(CustomFieldManagementService $service)
    {
        $this->crudService = $service;
    }

}
