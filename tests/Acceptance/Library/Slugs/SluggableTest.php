<?php
namespace Tests\Acceptance\Library\Slugs;

use Tectonic\Shift\Library\Slugs\Slug;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tests\AcceptanceTestCase;
use Tests\Stubs\SluggableStub;

class SluggableTest extends AcceptanceTestCase
{
    /**
     * Unfortunately we need to do an acceptance test for this particular use-case.
     */
	public function testSlugRetrieval()
    {
        $account = Account::create([]);

        $this->assertNotEmpty($account->slug);
        $this->assertInstanceOf(Slug::class, $account->slug);
    }
}
