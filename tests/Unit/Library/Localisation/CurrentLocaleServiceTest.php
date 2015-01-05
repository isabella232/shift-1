<?php
namespace Tests\Unit\Library\Localisation;

use Tectonic\Shift\Library\Facades\Consumer;
use Tectonic\Shift\Library\Localisation\CurrentLocaleService;
use Tests\UnitTestCase;

class CurrentLocaleServiceTest extends UnitTestCase
{
    private $currentLocale;
    private $language;

    public function init()
    {
        $this->language = new \stdClass;
        $this->language->code = 'en_GB';

        Consumer::shouldReceive('language')->andReturn($this->language);

        $this->currentLocale = new CurrentLocaleService;
    }

    public function testLanguageRetrieval()
    {
        $this->assertEquals($this->language, $this->currentLocale->language());
    }

    public function testCodeRetrieval()
    {
        $this->assertEquals($this->language->code, $this->currentLocale->code());
    }
}
