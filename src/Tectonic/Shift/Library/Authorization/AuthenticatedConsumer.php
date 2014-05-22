<?php namespace Tectonic\Shift\Library\Authorization;

use Authority\Authority;

/**
 * Class AuthenticatedConsumer
 *
 * When a user or api consumer authenticates against the system, a new AuthenticatedConsumer
 * object is created that will get passed to Authority.
 *
 * @package Tectonic\Shift\Library\Authorization
 */

final class AuthenticatedConsumer
{
	/**
	 * @var \Authority\Authority
	 */
	private $authority;

	/**
	 * @var Consumer
	 */
	private $consumer;

	public function __construct(Consumer $consumer, Authority $authority)
	{
		$this->authority = $authority;
		$this->consumer = $consumer;
	}

	/**
	 * Set the permissions for the consumer. This should be a multi-dimensional array that
	 * contains the permissions the consumer will be checked against.
	 *
	 * @param array $permissions
	 */
	public function setPermissions(array $permissions)
	{
		foreach ($permissions as $permission) {
			if ($this->allowable($permission)) {
				$this->authority->allow($permission['rule'], $permission['resource']);
			}
		}
	}

	/**
	 * Wrapper method for Authority's can() method. Exact same usage. The first parameter
	 * should be the required permission, and the second argument is the required resource.
	 *
	 * @param $permission
	 * @param $resource
	 * @return bool
	 */
	public function can($permission, $resource)
	{
		return $this->authority->can($permission, $resource);
	}

	/**
	 * Returns the authority object being used for the access checks.
	 *
	 * @return Authority
	 */
	public function getAuthority()
	{
		return $this->authority;
	}

	/**
	 * Defines whether or not a given permission is allowable. That is, that either:
	 *
	 * - the allow array element is defined and set to true OR
	 * - the deny array element is defined and set to false
	 *
	 * @param array $permission
	 * @return bool
	 */
	private function allowable(array $permission)
	{
		return @$permission['allow'] === true or @$permission['deny'] === false;
	}
}
