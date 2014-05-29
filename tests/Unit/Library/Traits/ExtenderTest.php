<?php namespace Tests\Unit\Library\Traits;

use Mockery as m;
use Tests\Stubs\ExtenderStub;
use Tests\Stubs\ExtensionStub;

class ExtenderTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        ExtenderStub::flushExtensions();

        m::close();
    }

    public function setUp()
    {
        $this->extender = new ExtenderStub;
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testNoMethodsAvailableShouldThrowException()
    {
        ExtenderStub::registerExtension(new ExtensionStub);

        $this->extender->someMethod();
    }

    public function testRegisteringANewObjectShouldRespondToExtenderCalls()
    {
        ExtenderStub::registerExtension(new ExtensionStub);

        $this->assertEquals('this result', $this->extender->example());
    }
}
