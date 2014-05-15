<?php namespace Tectonic\Shift\Library\Validation;

/**
 * Class Validator
 *
 * The validator class provides the base functionality required for any other validation classes for resources to
 * set rules, define the user input, and validate the input against these rules. There are two requirements before the validate
 * method can be called:
 *
 * - user input must be defined and
 * - the method that is to be called once rules are set should be defined.
 *
 * For example:
 *
 *     $validator = new ResourceValidator; // (extends the Validator base class)
 *     $validator->setInput(Input::get());
 *     $validator->forMethod('create');
 *     $validator->validate();
 *
 * If you are validating an existing resource, you can also provide that:
 *
 *     $validator->using($resource);
 *
 * This resource can be used by your own methods, say for example when updating existing records. The validator class does not
 * and will not use this resource object and is simply provided for you to use.
 *
 * If validation fails for whatever reason, a UserInputValidationException is thrown, which contains a generic message
 * as well as the specific errors for each individual error that may have occurred.
 *
 * @package Tectonic\Shift\Library\Validation
 */

use Validator as ValidatorFacade;

abstract class Validator
{
    /**
     * Stores the array of data that a user provided as part of the request.
     *
     * @var array
     */
    protected $input;

    /**
     * The method to be called on your validator that will define the rules.
     *
     * @var string
     */
    protected $method;

    /**
     * The resource object that you wish to use for other operations.
     *
     * @var object
     */
    protected $resource;

    /**
     * If you do not wish to define custom rules for each method, you can define a rules array on the validator class itself.
     * If no method is defined for setting the validation rules, then the rules array will be used as the basis for the validation.
     * If no rules are provided, then validation will pass.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Saves the user input on the object.
     *
     * @param array $input
     * @return Validator
     */
    public function setInput(array $input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Defines the method to be called when validation is executed. The method defined should return an
     * array of validation rules that will be executed in turn.
     *
     * @param string $method
     * @return Validator
     */
    public function forMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * For more complex validation requirements, you can define the resource you wish to use.
     *
     * @param $resource
     * @return Validator
     */
    public function using($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Validates the rules provided either by a custom method or on the class against the user input provided.
     *
     * @throws ValidationConfigurationException
     * @throws ValidationException
     */
    public function validate()
    {
        if (is_null($this->input)) {
            throw new ValidationConfigurationException('No user input was provided for validation.');
        }

        $rules = $this->getRules();

        $validator = ValidatorFacade::make($this->input, $rules);

        if ($validator->fails()) {
            $exception = new ValidationException;
            $exception->setValidationErrors($validator->messages()->all());
            $exception->setFailedFields($validator->failed());

            throw $exception;
        }
    }

    /**
     * Retrieves the rules that have defined for the validation.
     *
     * @return array
     * @throws ValidationConfigurationException
     */
    private function getRules()
    {
        if (!is_array($this->rules)) {
            throw new ValidationConfigurationException('Validation rules defined must be provided as an array.');
        }

        $rules = $this->rules;

        if (!is_null($this->method) and method_exists($this, $this->method)) {
            $rules = (array) call_user_func_array([$this, $this->method], [$this->resource]);
        }

        return $rules;
    }

    /**
     * Set rules via an external source. Sometimes you may wish to have one-off validation rules.
     *
     * @param array $rules
     * @return Validator
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }
}
