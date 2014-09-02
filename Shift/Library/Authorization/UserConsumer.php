<?php

namespace Tectonic\Shift\Library\Authorization;

/**
 * Class Consumer
 *
 * Simple value object for user with the AuthenticatedConsumer class. Must have an id
 * value.
 *
 * @package Tectonic\Shift\Library\Authorization
 */

final class UserConsumer implements ConsumerInterface
{
    /**
     * The User object reflecting the user that is currently accessing the application. This object is
     * not accessible externally. The reason for this is because we want both user and api consumers to
     * be accessed and dealt with in the same way. As a result, you can return the id for the consumer,
     * then query for a user based on that id if you require a user object. It is better, however - to
     * simply not think of actions performed against the API as a user.
     *
     * @var User
     */
    private $user;

	/**
	 * Constructs the class and sets the $id property.
	 *
     * @param UserInterface $user
	 */
	public function __construct(UserInterface $user)
	{
        $this->user = $user;
	}

    /**
     * Returns an array of accounts that the user can manage or contribute to.
     *
     * @return array
     * @todo Return the array of accounts the user can manage
     */
    public function getAccounts()
    {
        return $this->user->getAccounts();
    }

    /**
     * Returns the specific account id that the consumer is currently contributing to.
     *
     * @return integer
     */
    public function getAccountId()
    {
        // @todo: Implement the return of the account id
        return 0;
    }

    /**
     * Returns the id for the user accessing the application.
     *
     * @return integer
     */
    public function id()
    {
        return $this->user->getId();
    }
}
