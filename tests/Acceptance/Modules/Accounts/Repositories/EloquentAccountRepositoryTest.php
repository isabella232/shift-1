<?php
namespace Tests\Acceptance\Modules\Accounts\Repositories;

use App;
use Mockery;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentAccountRepository;
use Tectonic\Shift\Modules\Users\Repositories\EloquentUserRepository;
use Tests\AcceptanceTestCase;

class EloquentAccountRepositoryTest extends AcceptanceTestCase
{
    private $accountRepository;

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

        $this->accountRepository = App::make(EloquentAccountRepository::class);
        $this->userRepository = App::make(EloquentUserRepository::class);
    }

    /**
     * Test repository calls the correct methods on CREATE and READ operations.
     *
     * @test
     */
    public function testRepositoryPerformsCreateAndReadOperations()
    {
        $account = $this->create();
        $storedAccount = $this->accountRepository->getById($account->id);

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

        $this->accountRepository->update($account);

        $updatedAccount = $this->accountRepository->getById($account->id);

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

        $this->accountRepository->delete($account);

        $this->assertNull($this->accountRepository->getById($account->id));
    }

    /**
     * @return mixed
     */
    protected function create(array $data = [])
    {
        $data = array_merge($this->cleanData, $data);
        $account = $this->accountRepository->getNew($data);

        $this->accountRepository->save($account);

        return $account;
    }

    public function testOwnerAssignment()
    {
        $user = $this->userRepository->getNew(['firstName' => 'Kirk', 'lastName' => 'Bushell', 'email' => 'someemail@gmail.com', 'password' => '1234']);
        $this->userRepository->save($user);

        $account = $this->create();
        $account->setOwner($user);

        $this->accountRepository->save($account);

        $account = $this->accountRepository->getById($account->getId());

        $this->assertEquals($account->getOwner()->getId(), $user->getId());
    }
}
