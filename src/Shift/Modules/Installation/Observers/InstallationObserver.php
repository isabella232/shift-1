<?php
namespace Tectonic\Shift\Modules\Installation\Observers;

use Exception;
use Redirect;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationObserverInterface;

/**
 * Class InstallationObserver
 *
 * The following listener is just to be able to enforce certain behaviour with the result of installation.
 * For example, when validation fails we want to see the error messages output, and we want to throw
 * generic exceptions when installation failed for any other reason.
 *
 * @package Tectonic\Shift\Modules\Installation\Observers
 */
class InstallationObserver implements InstallationObserverInterface
{
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
     * Handler for when the installation has failed as a result of validation.
     *
     * @return mixed
     */
    public function onValidationFailure(ValidationException $exception)
    {
        return Redirect::back()->withInput()->withErrors($exception->getValidationErrors());
    }

    /**
     * Failure listener for when an install fails for any other reason.
     *
     * @return mixed
     */
    public function onFailure(Exception $exception)
    {
        return Redirect::back();
    }
}
