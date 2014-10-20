<?php

namespace Tests\Unit\Modules\Accounts\Validation;

use Tectonic\Shift\Modules\Accounts\Validators\DomainValidation;

class DomainValidationTest extends \Tests\AcceptanceTestCase
{
    /**
     * @expectedException Tectonic\Shift\Library\Validation\ValidationException
     */
    public function testValidationForDomainNameFormat()
    {
        $validator = new DomainValidation;
        $validator->setInput(['domain' => 'fakedomain']);
        $validator->validate();
    }

    public function testSuccessfulDomainValidation()
    {
        $validator = new DomainValidation;
        $validator->setInput(['domain' => 'www.realdomain.com']);

        $this->assertTrue($validator->validate());
    }
}
