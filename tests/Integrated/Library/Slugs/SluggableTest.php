<?php
namespace Tests\Integrated\Library\Slugs;

use Tectonic\Shift\Library\Slugs\Slug;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tests\IntegratedTestCase;
use Tests\Stubs\SluggableStub;

class SluggableTest extends IntegratedTestCase
{
    /**
     * Unfortunately we need to do an Integrated test for this particular use-case.
     */
	public function testSlugRetrieval()
    {
        $account = Account::create([]);

        $this->assertNotEmpty($account->slug);
        $this->assertInstanceOf(Slug::class, $account->slug);
    }
}
