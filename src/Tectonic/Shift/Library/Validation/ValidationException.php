<?php namespace Tectonic\Shift\Library\Validation;

class ValidationException extends \Exception implements JsonableInterface
{
    /**
     * Stores the errors that were found during validation.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * The default message for all validation. This gets returned along with the errors.
     *
     * @var string
     */
    protected $message = 'There is something wrong with the input provided. Please check the information you have entered and try again.';

    /**
     * Set the validation errors that occurred.
     *
     * @param array $errors
     */
    public function setValidationErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Similar to messages but this is just the failed fields.
     *
     * @param array $fields
     */
    public function setFailedFields(array $fields)
    {
        $this->failedFields = $fields;
    }

    /**
     * Required for the JsonableInterface implementation.
     *
     * @return array
     */
    public function toJson()
    {
        return $this->errors;
    }
}
