<?php

namespace Tectonic\Shift\Modules\Installation\Contracts;

use Tectonic\Shift\Library\Validation\ValidationException;

interface InstallationListenerInterface
{
    /**
     * Handler for when the installation is successful.
     *
     * @return mixed
     */
    public function onSuccess();

    /**
     * Handler for when the installation has failed as a result of validation.
     *
     * @return mixed
     */
    public function onValidationFailure(ValidationException $exception);

    /**
     * Failure listener for when an install fails for any other reason.
     *
     * @return mixed
     */
    public function onFailure();
}
