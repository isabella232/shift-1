<?php namespace Tectonic\Shift\Library\Authorization;

/**
 * Class Consumer
 *
 * Simple value object for user with the AuthenticatedConsumer class. Must have an id
 * value.
 *
 * @package Tectonic\Shift\Library\Authorization
 */
class Consumer
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
}
