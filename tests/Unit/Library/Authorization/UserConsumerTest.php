<?php

namespace Tests\Unit\Library\Authorization;

use Tectonic\Shift\Modules\Users\Entities\User;
use Tectonic\Shift\Library\Authorization\UserConsumer;

class UserConsumerTest extends \Tests\TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = new User;
        $this->user->id = 1;
    }

    public function testConsumerConstruction()
    {
        $consumer = new UserConsumer($this->user);

        $this->assertEquals(1, $consumer->id());
    }
}
