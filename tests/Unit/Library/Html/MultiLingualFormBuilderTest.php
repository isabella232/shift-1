<?php
namespace Tests\Unit\Library\Html;

use stdClass;
use Symfony\Component\DomCrawler\Crawler;
use Tectonic\Shift\Library\Html\MultiLingualFormBuilder;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tests\UnitTestCase;

class MultiLingualFormBuilderTest extends UnitTestCase
{
    private $formBuilder;

	public function init()
    {
        $english = new stdClass;
        $english->code = 'en_GB';

        $japanese = new stdClass;
        $japanese->code = 'ja_JP';

        $account = new stdClass;
        $account->languages = [$english, $japanese];

        CurrentAccount::shouldReceive('get')->andReturn($account);

        $this->formBuilder = new MultiLingualFormBuilder;
    }

    public function testTextFieldGeneration()
    {
        $model = new stdClass;

        $response = $this->formBuilder->text('name', $model);
        $crawler = new Crawler($response);

        $this->assertCount(2, $crawler->filter('input'));
        $this->assertEquals('translated[name][en_GB]', $crawler->filter('input')->eq(0)->attr('name'));
        $this->assertEquals('translated[name][ja_JP]', $crawler->filter('input')->eq(1)->attr('name'));
    }

    public function testTextareaFieldGeneration()
    {
        $model = new stdClass;

        $response = $this->formBuilder->textarea('description', $model);
        $crawler = new Crawler($response);

        $this->assertCount(2, $crawler->filter('textarea'));
        $this->assertEquals('translated[description][en_GB]', $crawler->filter('textarea')->eq(0)->attr('name'));
        $this->assertEquals('translated[description][ja_JP]', $crawler->filter('textarea')->eq(1)->attr('name'));
    }
}
