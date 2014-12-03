<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Tectonic\Shift\Library\Security\HoneyPot;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Identity\Users\Observers\RegistrationResponder;
use Tectonic\Shift\Modules\Identity\Users\Services\RegistrationService;

class RegistrationController extends Controller
{
    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * @var HoneyPot
     */
    private $honeyPot;

    /**
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService, HoneyPot $honeyPot)
    {
        $this->registrationService = $registrationService;
        $this->honeyPot = $honeyPot;
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
        if (!$this->honeyPot->allowed()) {
            return $this->respond('IP address has been blacklisted. Please contact '.Config::get('shift::emails.support'));
        }

        return $this->registrationService->registerUser(Input::get(), new RegistrationResponder);
    }
}
