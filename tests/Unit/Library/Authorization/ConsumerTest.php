<?php
namespace Tests\Unit\Library\Authorization;

use Illuminate\Support\Collection;
use Mockery as m;
use Tectonic\Shift\Library\Authorization\UserConsumer;
use Tectonic\Shift\Library\Authorization\Consumer;
use Tectonic\Shift\Library\Authorization\UserInterface;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

class ConsumerTest extends \Tests\UnitTestCase
{
	public function init()
	{
		$this->consumer = new Consumer;
	}

	public function testLanguageSettingAndRetrieval()
	{
		$this->consumer->setLanguage(new Language('en'));

		$this->assertEquals('en', $this->consumer->language()->code);
	}

	public function testAccountsSettingAndRetrieval()
	{
		$this->consumer->setAccounts(new Collection);

		$this->assertEquals(new Collection, $this->consumer->accounts());
	}
}
