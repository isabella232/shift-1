<?php namespace Tests\Acceptance\Modules\Fields\Repositories;

use App;
use Doctrine\ORM\EntityManager;
use Mockery;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;

class AccountRepositoryTest extends AcceptanceTestCase
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

        $this->repository = new DoctrineAccountRepository(App::make(EntityManager::class));
    }

    /**
     * Test repository calls the correct methods on CREATE and READ operations.
     *
     * @test
     */
    public function testRepositoryPerformsCreateAndReadOperations()
    {
        $account = $this->create();

        $this->assertSame($account, $this->repository->getById($account->getId()));
    }

    /**
     * Test repository performs UPDATE by calling correct methods.
     *
     * @test
     */
    public function testRepositoryPerformsUpdateOperation()
    {
        $account = $this->create();

        $account->setName('Updated test account');

        $this->repository->update($account);

        $updatedAccount = $this->repository->getById($account->getId());

        $this->assertSame($account, $updatedAccount);
        $this->assertEquals('Updated test account', $updatedAccount->getName());
    }

    /**
     * Test repository performs DELETE by calling correct methods
     *
     * @test
     */
    public function testRepositoryPerformsDeleteOperation()
    {
        $account = $this->create();

        $this->assertSame($account, $this->repository->getById($account->getId()));

        $this->repository->delete($account);

        $this->assertNull($this->repository->getById($account->getId()));
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
