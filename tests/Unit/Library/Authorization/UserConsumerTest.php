<?php

namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tectonic\Shift\Library\Authorization\UserConsumer;
use Tectonic\Shift\Library\Authorization\UserInterface;
use Tests\TestCase;

class UserConsumerTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = m::mock(UserInterface::class);
    }

    public function testConsumerConstruction()
    {
        $consumer = new UserConsumer($this->user);

        $this->user->shouldReceive('getId')->once()->andReturn(1);

        $this->assertEquals(1, $consumer->id());
    }
}
