<?php
namespace Tectonic\Shift\Modules\Installation\Services;

use Event;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Installation\Commands\InstallShiftCommand;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationResponderInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;

class InstallService
{
    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

    /**
     * @var LanguageRepositoryInterface
     */
    private $languages;

    /**
     * @param ValidationCommandBus $commandBus
     */
    public function __construct(ValidationCommandBus $commandBus, LanguageRepositoryInterface $languages)
    {
        $this->commandBus = $commandBus;
        $this->languages = $languages;
    }

    /**
     * Called on a new installation of Shift. Validates the input provided
     *
     * @param array $input
     * @param InstallationResponderInterface $responder
     * @return mixed
     */
    public function freshInstall(array $input = [], InstallationResponderInterface $responder)
    {
        $command = new InstallShiftCommand($input['name'], $input['host'], $input['language'], $input['email'], $input['password']);

        try {
            $this->commandBus->execute($command);
        }
        catch (ValidationException $exception) {
            return $responder->onValidationFailure($exception);
        }
        catch (Exception $exception) {
            return $responder->onFailure($exception);
        }

        return $responder->onSuccess();
    }

    /**
     * Returns the languages that are available to the system.
     *
     * @return collection
     */
    public function availableLanguages()
    {
        return $this->languages->getAll();
    }
}
