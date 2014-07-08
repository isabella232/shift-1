<?php namespace Tectonic\Shift\Library\Authorization;

/**
 * Class Consumer
 *
 * Simple value object for user with the AuthenticatedConsumer class. Must have an id
 * value.
 *
 * @package Tectonic\Shift\Library\Authorization
 */
class UserConsumer implements ConsumerInterface
{
	/**
	 * Stores the id for the consumer.
	 *
	 * @var
	 */
	public $id;

	/**
	 * Constructs the class and sets the $id property.
	 *
	 * @param $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

    /**
     * Returns an array of accounts that the user can manage or contribute to.
     *
     * @return array
     * @todo Return the array of accounts the user can manage
     */
    public function getAccounts()
    {
        return [];
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
}
