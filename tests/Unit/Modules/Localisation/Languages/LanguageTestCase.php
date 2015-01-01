<?php
namespace Tests\Unit\Modules\Localisation\Languages;

use Tectonic\Shift\Modules\Localisation\Languages\Language;
use Tests\UnitTestCase;

class LanguageTestCase extends UnitTestCase
{
    private $language;

	public function testValidLanguageCode()
    {
        $language = new Language('en_GB');

        $this->assertEquals('en_GB', $language->code);
        $this->assertEquals('English (Great Britain)', $language->language);
        $this->assertTrue($language->equals(new Language('en_GB')));
    }

    /**
     * @expectedException Tectonic\Shift\Modules\Localisation\Languages\UnsupportedLanguageException
     */
    public function testInvalidLanguageCreation()
    {
        $language = new Language('invalid');
    }
}
