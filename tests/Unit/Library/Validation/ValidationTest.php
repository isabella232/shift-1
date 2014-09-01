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
}
