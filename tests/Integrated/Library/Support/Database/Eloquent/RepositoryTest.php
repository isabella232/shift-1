<?php
namespace Tests\Integrated\Library\Support\Database\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Mockery as m;
use Tectonic\Shift\Library\Support\Exceptions\MethodNotFoundException;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentAccountRepository;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentRoleRepository;
use Tests\IntegratedTestCase;

class RepositoryTest extends IntegratedTestCase
{
    private $repository;

	public function init()
    {
        // Use the eloquent representation, as it is an eloquent repository afterall that we're testing.
        // We're also using the account repository, because it ticks all required boxes for testing.
        $this->repository = App::make(EloquentAccountRepository::class);
    }
    
    public function testRequireByWithNoResult()
    {
        $this->setExpectedException(ModelNotFoundException::class);

        $this->repository->requireByCreatedAt('bogus value');
    }

    public function testRequireBy()
    {
        $this->assertNotNull($this->repository->requireBy('id', '1'));
    }

    public function testSingleRecordRetrieval()
    {
        $this->assertNotNull($this->repository->getOneBy('id', '1'));
    }

    public function testAllRecords()
    {
        $this->assertCount(1, $this->repository->getAll());
    }

    public function testGetById()
    {
        $this->assertNotNull($this->repository->getById(1));
        $this->assertNull($this->repository->getById(938745983745));
    }

    /**
     * @expectedException \Exception
     */
    public function testSaveBatchWithNoArguments()
    {
        $this->repository->saveAll();
    }

    public function testSaveAllResources()
    {
        $this->repository->saveAll($this->account);
    }

    public function testSavingWithAccountRestriction()
    {
        $repository = App::make(EloquentRoleRepository::class);

        $role = new Role;
        $repository->save($role);

        $this->assertNotNull($role->accountId);
        $this->assertNotNull($role->createdAt);
        $this->assertNotNull($repository->getById($role->id));
    }

    public function testModelRetrieval()
    {
        $this->assertInstanceOf(Account::class, $this->repository->getModel());
    }

    public function testTranslationQueries()
    {
        $account = $this->repository->getByName('Account');

        $this->assertNotNull($account);
    }

    public function testSoftDelete()
    {
        $this->repository->delete($this->account);

        $this->assertNull($this->repository->getById($this->account->id));
    }

    public function testHardDelete()
    {
        $this->repository->delete($this->account, $permanent = true);

        $this->assertNull($this->repository->getById($this->account->id));
    }

    public function testUpdates()
    {
        $this->account->id = 2;

        $this->assertEquals($this->account, $this->repository->update($this->account));
    }

    public function testInvalidMethodCall()
    {
        $this->setExpectedException(MethodNotFoundException::class);

        $this->repository->lksjefljsdf();
    }
}
