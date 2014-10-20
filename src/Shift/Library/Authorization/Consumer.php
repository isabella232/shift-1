<?php namespace Tectonic\Shift\Library\Authorization;

use Authority\Authority;

/**
 * Class AuthenticatedConsumer
 *
 * When a user or api consumer authenticates against the system, a new AuthenticatedConsumer
 * object is created that will get passed to Authority.
 *
 * What may be confusing, is that the Consumer class has a method called setConsumer. Let's explain
 * what this means and why.
 *
 * The term Consumer is a general purpose term to describe any service or user that may consume
 * the API provided by Shift. However, there are different types of consumers: api, user, iphone.etc.
 *
 * As a result, when the setConsumer method is called, it's really asking for the TYPE of consumer
 * that is executing the request, whether it be an ApiConsumer or a UserConsumer.etc. This is necessary
 * because the various types of consumers have slightly different rules and ways of managing
 * their access.
 *
 * @package Tectonic\Shift\Library\Authorization
 */

final class Consumer
{
	/**
	 * @var \Authority\Authority
	 */
	private $authority;

	/**
	 * @var ConsumerInterface
	 */
	private $consumer;

	/**
	 * @param Authority $authority
	 */
	public function __construct(Authority $authority)
	{
		$this->authority = $authority;
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
     * Sets the consumer that is currently authorised to work with the api.
     *
     * @param ConsumerInterface $consumer
     */
    public function setConsumer(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
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
	 * Returns the consumer object that is currently authenticated against the API.
	 *
	 * @return UserConsumer
	 */
	public function getConsumer()
	{
		return $this->consumer;
	}

    /**
     * Returns the accounts that this consumer can safely manage and work with.
     *
     * @return array
     */
    public function getAccounts()
    {
        return $this->getConsumer()->getAccounts();
    }

    /**
     * Return the account id that the consumer is currently managing.
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->getConsumer()->getAccountId();
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
