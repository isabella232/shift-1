<?php

namespace Tectonic\Shift\Controllers;

use Request;
use Redirect;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Library\Validation\ValidationException;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Services\InstallService;
use View;

class InstallationController extends Controller implements InstallationListenerInterface
{
    // Our installation controller uses a different layout to the main app
    public $layout = 'shift::layouts.installation';

    /**
     * The installation service that will be used for actually installing/setting up the application.
     *
     * @var InstallService
     */
    private $installService;

    /**
     * @param InstallService $installService
     */
    function __construct(InstallService $installService)
    {
        $this->installService = $installService;
    }

    /**
     * Renders the installation/setup form.
     *
     * @return Response
     */
    public function getInstall()
    {
        $host = Request::getHttpHost();

        return View::make('shift::installation.setup', compact('host'));
    }

    /**
     * Handles the data submitted from the form.
     *
     * @return Response
     */
    public function postInstall()
    {
        return $this->installService->freshInstall(Request::all(), $this);
    }

    /**
     * Handler for when the installation is successful.
     *
     * @return mixed
     */
    public function onSuccess()
    {
        return Redirect::to('/');
    }

    /**
     * Handler for when the installation has failed validation.
     *
     * @return mixed
     */
    public function onValidationFailure(ValidationException $exception)
    {
        return Redirect::back()->withInput()->withErrors($exception->getValidationErrors());
    }

    /**
     * Handles all other failures.
     */
    public function onFailure()
    {
        return Redirect::back();
    }
}
