<?php
namespace Tectonic\Shift\Library\Authorization;

use App;
use Authority\Authority;
use Log;
use Illuminate\Support\Str;

/**
 * Class Bouncer
 *
 * The bouncer acts like a club bouncer. It'll ask for the identity of a given consumer
 * and then based on their identity and permissions, and the route that they are trying to access
 * will determine whether or not they are allowed in.
 *
 * @package Tectonic\Shift\Library\Authorization
 */

final class Bouncer
{
	/**
	 * The name of the resource that we're wanting to do access checks against (such as User).
	 *
	 * @var string
	 */
	private $resource;

	/**
	 * An array of actions and required permissions.
	 *
	 * @var array
	 */
	private $matrix;

	/**
	 * The authority object will be used to do permission checks.
	 *
	 * @var Authority
	 */
	private $authority;

	/**
	 * Used as a kind of pointer. If any authorise method passes, this should be set to true.
	 *
	 * @var bool
	 */
	private $permitted = false;

	/**
	 * The resource provided must be the resource that is matched throughout the system. Usually this in camelcase,
	 * such as User or EntrySubmission.etc.
	 *
	 * @param $resource
	 */
	public function __construct(Authority $authority, $resource)
	{
		$this->resource = $resource;
		$this->authority = $authority;
	}

	/**
	 * Setup the default access for resources. This is not needed for all which is why it is an additional
	 * method, but will probably be used by 80% of the resources defined for shift. This method sets
	 * up the following resource requests and permissions required:
	 *
	 *    GET index: read
	 *    GET export: read
	 *    GET show: read
	 *    POST index: create
	 *    PUT update: update
	 *    DELETE index: delete
	 *
	 * If the resource for the bouncer instance is for example, User, then with the matrix above, the authenticated
	 * consumer must have the relevant permissions for the User resource.
	 */
	public function setupDefaultAccess()
	{
		$this->addRequiredAccess('get', 'index', 'read');
		$this->addRequiredAccess('get', 'export', 'read');
		$this->addRequiredAccess('get', 'show', 'read');
		$this->addRequiredAccess('post', 'index', 'create');
		$this->addRequiredAccess('put', 'update', 'update');
		$this->addRequiredAccess('delete', 'index', 'delete');
	}

	/**
	 * Adds an access requirement to the matrix
	 *
	 * @param string $method
	 * @param string $action
	 * @param mixed $access_requirement - could be a string, an array, or even a closure
	 * @return void
	 */
	public function addRequiredAccess($method, $action, $access_requirement)
	{
		if (!is_array($access_requirement)) {
			$access_requirement = [$access_requirement];
		}

		$method = $this->method($method);

		if (!isset($this->matrix[$method])) {
			$this->matrix[$method] = [];
		}

		if (!isset($this->matrix[$method][$action])) {
			$this->matrix[$method][$action] = $access_requirement;
		}
		else {
			$this->matrix[$method][$action] = array_merge_recursive($this->matrix[$method][$action], $access_requirement);
		}
	}

	/**
	 * Determines whether or not a user has access to a given action.
	 *
	 * @param string $method get or post
	 * @param string $action
	 * @return boolean
	 */
	public function allowed($method, $action)
	{
		$this->reset();

		$method = $this->method($method);

		$this->debug("Access request from [{$this->resource}] with [$method] to [$action].");

		// let's see if such an action and resource exists in the matrix
		if (isset($this->matrix[$method][$action])) {
			$this->authoriseMatrix($this->matrix[$method][$action], $this->resource);
		}

		$this->debug('Access request denied.');

		return $this->permitted();
	}

	/**
	 * Once a set of rules is found for a method and action, we can then parse the rules and determine
	 * whether or not the user has access to the requested method and action.
	 *
	 * @param array $rules
	 * @param string $resource
	 * @return bool
     */
	protected function authoriseMatrix(array $rules, $resource)
	{
		foreach ($rules as $key => $check) {
			$resource = is_numeric($key) ? $this->resource : $key;

			if (is_callable($check)) {
				$this->authoriseFunction($check);
			}
			else if (is_array($check)) {
				$this->authoriseArray($check, $resource);
			}
			else {
				$this->authoriseRule($check, $resource);
			}
		}
	}

	/**
	 * Determines whether or not a user has access based on the array of required rules.
	 *
	 * @param array $rules
	 * @param string $resource
	 * @return bool
     */
	public function authoriseArray(array $rules, $resource)
	{
		foreach ($rules as $rule) {
			if ($this->authoriseRule($rule, $resource)) {
				$this->permit();
			}
		}
	}

	/**
	 * The default authorization check. See if access is provided for a given permission rule and resource.
	 *
	 * @param string $rule
	 * @param string $resource
	 * @return bool
	 */
	public function authoriseRule($rule, $resource)
	{
		if ($this->can($rule, $resource)) {
			$this->debug("Access request granted from [$resource] on rule $rule");

			return $this->permit();
		}
	}

	/**
	 * Some authorization requires very complex conditions. Passing a callback as part of the rule requirement
	 * for the matrix allows this functionality. This method executes and returns the result of that callback.
	 *
	 * @param \Closure $function
	 * @return bool
	 */
	public function authoriseFunction(\Closure $function)
	{
		if ($function()) {
			$this->debug("Access request granted for provided closure.");
			$this->permit();
		}
	}

	/**
	 * Returns the permitted value.
	 *
	 * @return bool
     */
	public function permitted()
	{
		return $this->permitted;
	}

	/**
	 * Permits access.
	 */
	public function permit()
	{
		return $this->permitted = true;
	}

	/**
	 * Reset the permitted check. Necessary if doing numerous checks.
	 */
	public function reset()
	{
		$this->permitted = false;
	}

    /**
     * Determines whether or not a consumer can view a resource.
     *
     * @param $rule
     * @param $resource
     * @return bool
     */
    private function can($rule, $resource)
    {
        // Guest access allowed
        if ('guest' == $rule) {
	        return $this->permit();
        }

        if ($this->authority->can($rule, $resource)) {
	        return $this->permit();
        }

	    return false;
    }

	/**
	 * Inverse action of allowed
	 *
	 * @param string $method
	 * @param string $action
	 * @return boolean
	 */
	public function denied($method, $action)
	{
		return !$this->allowed($method, $action);
	}

	/**
	 * Determines the required action based on the method provided. This is necessary for requests where the URL
	 * contains a numeral representing an individual resource.
	 *
	 * @param $method
	 * @return string
	 */
	public function determineAction($method)
	{
		switch ($method) {
			case 'put':
				$action = 'update';
				break;
			case 'delete':
				$action = 'index';
				break;
			case 'post':
				$action = 'create';
				break;
			case 'get':
			default:
				$action = 'view';
				break;
		}

		return $action;
	}

	/**
	 * Returns the matrix that has been previously defined.
	 *
	 * @return array
	 */
	public function getMatrix()
	{
		return $this->matrix;
	}

	/**
	 * Does some basic transformation for methods, to set a standard use
	 *
	 * @param string $method
	 * @return string
	 * @access private
	 */
	private function method($method)
	{
		return Str::lower($method);
	}

	/**
	 * Simply a wrapper a method for the logger.
	 *
	 * @param string $message
     */
	private function debug($message)
	{
		Log::debug($message);
	}
}
