<?php
namespace Tectonic\Shift\Library\Authorization;

use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

/**
 * Class ConsumerManager
 *
 * Simple value object for user with the AuthenticatedConsumer class.
 *
 * @author Kirk Bushell
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
     * @param $user
	 */
	public function __construct($user)
	{
        $this->user = $user;
	}

    /**
     * Returns an array of accounts that the user can manage or contribute to.
     *
     * @return array
     */
    public function accounts()
    {
        return $this->user->accounts();
    }

    /**
     * Returns the id for the user accessing the application.
     *
     * @return integer
     */
    public function id()
    {
        return $this->user->id;
    }

    /**
     * Returns the language that the consumer prefers.
     *
     * @return Language
     */
    public function language()
    {
        // @TODO: Add support of user-preferred language
        return CurrentAccount::get()->defaultLanguage();
    }

    /**
     * Type is user.
     *
     * @return ConsumerType
     */
    public function type()
    {
        return new ConsumerType('user');
    }
}
