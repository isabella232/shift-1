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

        $this->cleanData = [];

        $this->accountRepository = App::make(EloquentAccountRepository::class);
        $this->userRepository = App::make(EloquentUserRepository::class);
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
}
