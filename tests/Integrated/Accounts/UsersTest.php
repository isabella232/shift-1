<?php

class UsersTest extends Tests\TestCase
{
	public function testGetIndexReturnsSearchResults()
	{
		$this->call('GET', 'users');

		$this->assertResponseOk();
	}
}
