<?php
namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tectonic\Shift\Library\Authorization\ConsumerType;
use Tectonic\Shift\Library\Authorization\UserConsumer;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tests\UnitTestCase;

class UserConsumerTest extends UnitTestCase
{
    private $user;
    private $consumer;

    public function setUp()
    {
        parent::setUp();

        $this->user = m::mock(User::class);
        $this->consumer = new UserConsumer($this->user);
    }

    public function testConsumerConstruction()
    {
        $this->user->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);

        $this->assertEquals(1, $this->consumer->id());
    }

    public function testUserAccountsRetrieval()
    {
        $this->user->shouldReceive('accounts')->once()->andReturn('accounts');

        $this->assertEquals('accounts', $this->consumer->accounts());
    }

    public function testUserLanguageRetrieval()
    {
        $mockAccount = m::mock('accounts');
        $mockAccount->shouldReceive('defaultLanguage')->andReturn('language');

        CurrentAccount::shouldReceive('get')->andReturn($mockAccount);

        $this->assertEquals('language', $this->consumer->language());
    }

    public function testConsumerType()
    {
        $this->assertEquals($this->consumer->type(), new ConsumerType('user'));
    }
}
