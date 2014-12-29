<?php

namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tectonic\Shift\Library\Authorization\UserConsumer;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tests\UnitTestCase;

class UserConsumerTest extends UnitTestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = m::mock(User::class);
    }

    public function testConsumerConstruction()
    {
        $consumer = new UserConsumer($this->user);

        $this->user->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);

        $this->assertEquals(1, $consumer->id());
    }
}
