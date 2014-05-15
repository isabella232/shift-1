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

        // We have to force this because of how method_exists does checks (it would never fire)
        $this->validator->setRules(['name' => 'required']);

        $this->validator->validate();
    }
}
