<?php
namespace Tests\Acceptance\Modules\Accounts\Repositories;

use Illuminate\Support\Facades\App;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Models\Domain;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentAccountRepository;
use Tests\AcceptanceTestCase;

class EloquentAccountRepositoryTest extends AcceptanceTestCase
{
    public function init()
    {
        $this->repository = App::make(EloquentAccountRepository::class);
    }

    public function testAccountRetrievalByDomain()
    {
        $this->account->addDomain('www.someurl.com');
        $this->account->addDomain('subdomain.someurl.com');

        $account = $this->repository->requireByDomain('www.someurl.com');

        $this->assertNotNull($account);
        $this->assertEquals('www.someurl.com', $account->domains()->first()->domain);
    }

    /**
     * @expectedException Tectonic\Shift\Modules\Accounts\AccountNotFoundException
     */
    public function testInvalidDomainRetrieval()
    {
        $this->account->addDomain('www.someurl.com');

        $this->repository->requireByDomain('invalid domain');
    }

    public function testCount()
    {
        $account = Account::create([]);
        $account->delete();

        $this->assertSame(2, $this->repository->getCount());
    }
}
