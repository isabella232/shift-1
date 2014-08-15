<?php namespace Tests\Unit\Modules\Localisation\Validators;

use Mockery as m;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleCustomValidationRules;
use Tests\TestCase;

class LocaleCodeValidatorTest extends TestCase
{
    public function testValidationOnLocaleCode()
    {
        $validator = new LocaleCustomValidationRules();

        $this->assertTrue($validator->localCode('code', 'en_GB', []));
        $this->assertFalse($validator->localCode('code', 'enn_GB', []));
        $this->assertFalse($validator->localCode('code', 'en_GBB', []));
        $this->assertFalse($validator->localCode('code', 'EN_gb', []));
        $this->assertFalse($validator->localCode('code', 'enGB', []));
        $this->assertFalse($validator->localCode('code', 'engb', []));
        $this->assertFalse($validator->localCode('code', 'ENGB', []));
        $this->assertFalse($validator->localCode('code', 'en-GB', []));
    }
}
