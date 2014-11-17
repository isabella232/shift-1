<?php
namespace Tectonic\Shift\Modules\Installation\Services;

use Event;
use Tectonic\Shift\Library\Validation\ValidationException;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\AccountDomainsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountUsersService;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Validators\InstallValidation;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Services\LanguageManagementService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Repositories\EloquentUserRepository;
use Tectonic\Shift\Modules\Users\Services\UserManagementService;

class InstallService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var LanguageRepositoryInterface
     */
    private $languageRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, LanguageRepositoryInterface $languageRepository)
    {
        $this->userRepository = $userRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * Called on a new installation of Shift. Validates the input provided
     *
     * @param array $input
     * @param InstallationListenerInterface $listener
     * @return mixed
     */
    public function freshInstall(array $input = [], InstallationListenerInterface $listener)
    {
        try {
            $this->validate($input);
            $this->installShift($input);
        }
        catch (ValidationException $exception) {
            return $listener->onValidationFailure($exception);
        }

        return $listener->onSuccess();
    }

    /**
     * Validate the input that was provided from the setup process.
     *
     * @param array $input
     * @return InstallValidation
     * @throws ValidationException
     */
    public function validate(array $input = [])
    {
        $validation = new InstallValidation;
        $validation->setInput($input);
        $validation->validate();

        return $validation;
    }

    /**
     * Installs shift, setting up any required data that is general to shift operations. At
     * this particular point in time, the Install service doesn't actually do anything itself
     * other than validate the input and fire a few events. Other modules then hook into those
     * events to setup their required data.
     *
     * @fires shift.installed
     * @fires shift.installing
     * @param array $input
     */
    public function installShift(array $input = [])
    {
        $admin = $this->setupUser($input);

        Event::fire('shift.installing', [$admin, $input]);
        Event::fire('shift.installed', [$admin, $input]);
    }

    /**
     * Setup default locale
     *
     * @return mixed
     * */
    public function setupLocale()
    {
        $data = ['locale' => 'English (Great Britain)', 'code' => 'en_GB'];
        $locale = $this->localeManagementService->create($data);

        return $locale;
    }

    /**
     * Creates a new user for the account based on the input provided.
     *
     * @param array $input
     * @return mixed
     */
    public function setupUser(array $input)
    {
        $userData = array_merge($input, ['firstName' => 'Super', 'lastName' => 'Admin']);

        $user = $this->userRepository->getNew($userData);

        $this->userRepository->save($user);

        return $user;
    }

    /**
     * Returns the available languages on the system.
     *
     * @return Collection
     */
    public function availableLanguages()
    {
        return $this->languageRepository->getAll();
    }
}
