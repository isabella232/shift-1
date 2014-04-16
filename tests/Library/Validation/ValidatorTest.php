<?php

use Mockery as m;

class ValidatorTest extends Tests\TestCase
{
	public function setUp()
	{
        parent::setUp();

		$this->validator = m::mock('Tectonic\Shift\Library\Validation\Validator')->makePartial();
	}

    /**
     * @expectedException Tectonic\Shift\Library\Validation\ValidationConfigurationException
     */
	public function testValidatingWithoutInputShouldThrowException()
	{
		$this->validator->validate();
	}

    /**
     * @expectedException Tectonic\Shift\Library\Validation\ValidationException
     */
    public function testWhenValidationFailsAValidationExceptionShouldBeThrown()
    {
        $this->validator->setInput([]);

        // Here we're just forcing a rule to be defined without having to setup a stub class
        $this->validator->forMethod('create');
        $this->validator->shouldReceive('create')->once()->andReturn(['name' => 'required']);

        $this->validator->validate();
    }
}
