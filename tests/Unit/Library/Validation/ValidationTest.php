<?php namespace Tests\Unit\Library\Validation;

use Mockery as m;
use Tectonic\Shift\Library\Validation\ValidationException;
use Tests\Stubs\ValidationStub;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * @expectedException Tectonic\Shift\Library\Validation\ValidationException
     */
	public function testValidatingWithoutInputShouldThrowException()
	{
		$validator = new ValidationStub();
        $validator->validate();
	}

    public function testReturnOfValidationErrors()
    {
        $validator = new ValidationStub();

        try {
            $validator->validate();
        }
        catch (ValidationException $e) {
            $errors = $e->getFailedFields();

            $this->assertArrayHasKey('name', $errors);
        }
    }

    public function testInputReturnValues()
    {
        $input = ['key' => 'value'];

        $validator = new ValidationStub;
        $validator->setInput($input);

        $this->assertEquals($input, $validator->getInput());
        $this->assertEquals('value', $validator->getValue('key'));
        $this->assertNull($validator->getValue('does not exist'));
    }
}
