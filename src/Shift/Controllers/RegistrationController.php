<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Users\Observers\RegistrationResponder;
use Tectonic\Shift\Modules\Users\Services\RegistrationService;

class RegistrationController extends Controller
{
    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Main request that is made for the registration form.
     */
    public function form()
    {
        return $this->respond('shift::users.register');
    }

    /**
     * Handles the submission of user registrations.
     */
    public function register()
    {
        return $this->registrationService->registerUser(Input::get(), new RegistrationResponder);
    }
}
