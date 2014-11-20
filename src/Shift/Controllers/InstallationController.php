<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Request;
use Redirect;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Installation\Services\InstallService;
use Tectonic\Shift\Modules\Installation\Observers\InstallationObserver;
use View;

class InstallationController extends Controller
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
        return $this->installService->freshInstall(Input::get(), new InstallationObserver);
    }
}
