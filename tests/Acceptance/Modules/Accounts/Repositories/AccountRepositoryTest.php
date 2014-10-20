<?php namespace Tests\Acceptance\Modules\Accounts\Repositories;

use App;
use Doctrine\ORM\EntityManager;
use Mockery;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentAccountRepository;
use Tests\AcceptanceTestCase;

class EloquentAccountRepositoryTest extends AcceptanceTestCase
{
    /**
     * Data array complete with all required field to make a new CustomField
     *
     * @var array
     */
    protected $cleanData;

    /**
     * Setup method to run before each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->cleanData = [
            'name' => 'Test account'
        ];

        $this->repository = App::make(EloquentAccountRepository::class);
    }

    /**
     * Test repository calls the correct methods on CREATE and READ operations.
     *
     * @test
     */
    public function testRepositoryPerformsCreateAndReadOperations()
    {
        $account = $this->create();
        $storedAccount = $this->repository->getById($account->id);

        $this->assertEquals($account->id, $storedAccount->id);
    }

    /**
     * Test repository performs UPDATE by calling correct methods.
     *
     * @test
     */
    public function testRepositoryPerformsUpdateOperation()
    {
        $account = $this->create();
        $account->name ='Updated test account';

        $this->repository->update($account);

        $updatedAccount = $this->repository->getById($account->id);

        $this->assertEquals('Updated test account', $updatedAccount->name);
    }

    /**
     * Test repository performs DELETE by calling correct methods
     *
     * @test
     */
    public function testRepositoryPerformsDeleteOperation()
    {
        $account = $this->create();

        $this->repository->delete($account);

        $this->assertNull($this->repository->getById($account->id));
    }

    /**
     * @return mixed
     */
    protected function create(array $data = [])
    {
        $data = array_merge($this->cleanData, $data);
        $account = $this->repository->getNew($data);

        $this->repository->save($account);

        return $account;
    }


}
