<?php

class RolesTest extends Tests\TestCase
{
	public function testGetIndexReturnsSearchResults()
	{
		$this->call('GET', 'roles');

		$this->assertResponseOk();
	}

    public function testCreateNewRole()
    {
        $this->call('POST', 'roles');

        $this->markTestIncomplete( 'Issue with routes still to be resolved' );
    }
}
