<?php namespace Tests\Unit\Modules\Localisation\Validators;

use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Modules\Localisation\Validators\LocaleCustomValidationRules;

class LocaleCodeValidatorTest extends TestCase
{
    public function testValidationOnLocaleCode()
    {
        $validator = new LocaleCustomValidationRules();

        // Test a variety of different formats to ensure full coverage
        $this->assertTrue($validator->localeCode('code', 'en_GB', []));
        $this->assertFalse($validator->localeCode('code', 'enn_GB', []));
        $this->assertFalse($validator->localeCode('code', 'en_GBB', []));
        $this->assertFalse($validator->localeCode('code', 'EN_gb', []));
        $this->assertFalse($validator->localeCode('code', 'enGB', []));
        $this->assertFalse($validator->localeCode('code', 'engb', []));
        $this->assertFalse($validator->localeCode('code', 'EN', []));
        $this->assertFalse($validator->localeCode('code', 'en-GB', []));
    }
}
