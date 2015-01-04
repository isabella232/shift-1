<?php
/**
 * Generic catch-all solution for any validation exceptions that get thrown during validation steps.
 * The default behaviour is for the user to be redirected back to the page they were just one,
 * whereby the errors will be shown in the correct locations.
 */
App::error(function(\Tectonic\Application\Validation\ValidationException $exception) {
    return Redirect::back()->withInput()->withErrors($exception->getValidationErrors());
});
