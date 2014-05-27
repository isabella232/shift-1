<?php namespace Tectonic\Shift\Library\Authorization;

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
	 * Stores the authenticated consumer object which will be used for the authorization of requested actions.
	 *
	 * @var AuthenticatedConsumer
	 */
	private $consumer;

	/**
	 * The resource provided must be the resource that is matched throughout the system. Usually this in camelcase,
	 * such as User or EntrySubmission.etc.
	 *
	 * @param $resource
	 * @param AuthenticatedConsumer $consumer
	 */
	public function __construct($resource, AuthenticatedConsumer $consumer)
	{
		$this->resource = $resource;
		$this->consumer = $consumer;
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
			$this->matrix[$method][$action] = array_merge($this->matrix[$method][$action], $access_requirement);
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
		$method = $this->method($method);

		// If the action is a #, then we follow RESTful conventions - the action should actually be the index action
		if (is_numeric($action)) {
			$action = $this->determineAction($method);
		}

		Log::info('ACCESS REQUEST: FROM ' . $this->resource . ' WITH ' . $method .' TO ' . $action);

		// let's see if such an action and resource exists in the matrix
		if (isset($this->matrix[$method][$action])) {
			$auth_check = $this->matrix[$method][$action];

			foreach ($auth_check as $check) {
				// if the auth check value is a callable function, let that handle whether
				// access is allowable or not for the user's request.
				if (is_callable($check) && $this->authoriseByFunction($check)) {
					return true;
				}

				//If auth check value is an array, check each member rule
				if (is_array($check)) {
					foreach ($check as $key => $rule) {
						if (is_callable($rule) && $this->authoriseByFunction($rule)) return true;

						$this_resource = is_numeric($key) ? $this->resource : $key;

						if (is_array($rule)) {
							// looks like we have a custom resource and an array of permissons allowed
							foreach ($rule as $r) {
								if ($this->authoriseByRule($r, $this_resource)) return true;
							}
						}
						else {
							// 'any' means anyone can do it
							if ($this->authoriseByRule($rule, $this_resource)) return true;
						}
					}
				}
				else {
					if ($this->authoriseByRule($check, $this->resource)) return true;
				}
			}
		}

		Log::info('ACCESS REQUEST: DENIED');

		return false;
	}

	/**
	 * Some authorization requires very complex conditions. Passing a callback as part of the rule requirement
	 * for the matrix allows this functionality. This method executes and returns the result of that callback.
	 *
	 * @param \Closure $function
	 * @return bool
	 */
	private function authoriseByFunction(\Closure $function)
	{
		Log::info('ACCESS REQUEST: Auth check defined as an anonymous function.');

		return $function();
	}

	/**
	 * The default authorization check. See if access is provided for a given permission rule and resource.
	 *
	 * @param $rule
	 * @param null $resource
	 * @return bool
	 */
	private function authoriseByRule($rule, $resource = null)
	{
		// Guest access allowed
		if ('any' == $rule) return true;

		if (is_null($resource)) {
			$resource = $this->resource;
		}

		if ($this->consumer->can($rule, $resource)) {
			Log::info('ACCESS REQUEST: GRANTED FROM ' . $resource . ' ON RULE: ' . $rule);
			return true;
		}
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
}
