<?php
namespace Tests\Stubs;

use Exception;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationResponderInterface;

class InstallationResponder implements InstallationResponderInterface
{

    /**
     * Handler for when the installation is successful.
     *
     * @return mixed
     */
    public function onSuccess()
    {
        // TODO: Implement onSuccess() method.
    }

    /**
     * Handler for when the installation has failed as a result of validation.
     *
     * @return mixed
     */
    public function onValidationFailure(ValidationException $exception)
    {
        print_r($exception->getFailedFields());

        throw $exception;
    }

    /**
     * Failure listener for when an install fails for any other reason.
     *
     * @return mixed
     */
    public function onFailure(Exception $exception)
    {
        throw $exception;
    }
}
 