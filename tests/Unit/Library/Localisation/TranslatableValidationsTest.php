<?php
namespace Tests\Unit\Library\Localisation;

use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tests\Stubs\TranslatableValidationsStub;
use Tests\UnitTestCase;

class TranslatableValidationsTest extends UnitTestCase
{
	public function testCreationOfValidationRules()
    {
        $languages = m::mock('languagerepository');
        $languages->languages = $languages;

        $languages->shouldReceive('lists')->once()->andReturn(['en_GB', 'en_US']);

        CurrentAccount::shouldReceive('get')->once()->andReturn($languages);

        $validations = (new TranslatableValidationsStub)->required('name');

        $this->assertcount(2, $validations);
        $this->assertArrayHasKey('translated.name.en_GB', $validations);
        $this->assertArrayHasKey('translated.name.en_US', $validations);
    }
}
