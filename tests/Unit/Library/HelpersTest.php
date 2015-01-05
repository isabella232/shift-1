<?php
namespace Tests\Unit\Library;

use Mockery as m;
use Tectonic\LaravelLocalisation\Translator\Translated\Entity;
use Tectonic\Shift\Library\Facades\CurrentLocale;
use Tests\UnitTestCase;

class HelpersTest extends UnitTestCase
{
    private $model;

    public function init()
    {
        $this->model = m::mock(Entity::class);
        $this->model->title['en_GB'] = 'Colours';
        $this->model->title['en_US'] = 'Colors';
    }

	public function testMultilingualFieldTranslationFetching()
    {
        CurrentLocale::shouldReceive('code')->once()->andReturn('en_GB');

        $this->assertEquals('Colours', lang($this->model, 'title'));
    }

    public function testInvalidFieldCheck()
    {
        CurrentLocale::shouldReceive('code')->once()->andReturn('en_GB');

        $this->assertEquals('&lt;&lt;NTA&gt;&gt;', lang($this->model, 'name'));
    }

    public function testInvalidLanguageCodeCheck()
    {
        CurrentLocale::shouldReceive('code')->once()->andReturn('lkasdljsdf');

        $this->assertEquals('&lt;&lt;NTA&gt;&gt;', lang($this->model, 'title'));
    }
}
