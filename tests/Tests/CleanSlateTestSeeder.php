<?php
namespace Tests;

use Illuminate\Database\Seeder;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;

/**
 * Class CleanSlateTestSeeder
 *
 * Seeds the data within the database - designed specifically for clean-slate data testing ONLY. This allows
 * developers to either seed their development databases, or seed the test database with required data for
 * a new test run.
 *
 * @package Tests
 */
class CleanSlateTestSeeder extends Seeder
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accounts;

    public function __construct(AccountRepositoryInterface $accounts)
    {
        $this->accounts = $accounts;
    }

	public function run()
    {
        $this->seedAccount();
    }

    protected function seedAccount()
    {
        $account = Account::install();

        $this->accounts->save($account);

        $this->translationService->sync($account, ['name' => ['en_GB' => 'Tectonic']]);
    }
}
