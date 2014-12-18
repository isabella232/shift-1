<?php
namespace Tectonic\Shift\Library\Support;

class DefaultResponder
{
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Handler for when the installation is successful.
     *
     * @return mixed
     */
    public function onSuccess()
    {
        return Redirect::to($this->baseUrl);
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
