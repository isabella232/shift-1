<?php namespace Tectonic\Shift\Library\Authorization;

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
	private $resource;

	private $matrix;

	public function __construct($resource)
	{
		$this->resource = $resource;
	}

	public function addRequiredAccess()
	{

	}

	public function registerDefaultAccess()
	{
		// Setup the default matrix conditions
		$this->addRequiredAccess('get', 'index', 'read');
		$this->addRequiredAccess('get', 'export', 'read');
		$this->addRequiredAccess('get', 'view', 'read');
		$this->addRequiredAccess('post', 'index', 'create');
		$this->addRequiredAccess('put', 'update', 'update');
		$this->addRequiredAccess('delete', 'index', 'delete');

		$this->init();

		// Fire an event to allow other modules to define permissions
		Event::fire( 'access.' . strtolower( Str::plural( $this->resource() ) ), [ $this ] );
	}
}
