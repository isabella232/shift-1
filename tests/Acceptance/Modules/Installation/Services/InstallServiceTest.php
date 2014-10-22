<?php
namespace Tests\Acceptance\Modules\Installation\Services;

use App;
use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Services\InstallService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tests\AcceptanceTestCase;
use Tests\Stubs\Installation\InstallationListener;

class InstallServiceTest extends AcceptanceTestCase
{
	public function testInstallation()
    {
        // Setup
        $this->setupTest();

        // Now we make sure that the required data has been added
        $this->assertUser();
        $this->assertAccount();
        $this->assertDomain();
    }

    private function setupTest()
    {
        $input = [
            'name' => 'Install service test',
            'host' => 'somehost.com',
            'email' => 'installer@tectonic.com.au',
            'password' => '1234'
        ];

        $installService = App::make(InstallService::class);
        $installService->freshInstall($input, new InstallationListener);
    }

    private function assertUser()
    {
        // Setup the repository
        $users = App::make(UserRepositoryInterface::class);
        $user = $users->getAll()[0];

        // User assertions
        $this->assertEquals('Super', $user->getFirstName());
        $this->assertEquals('Admin', $user->getLastName());
    }

    private function assertAccount()
    {
        // Setup the repository
        $accounts = App::make(AccountRepositoryInterface::class);
        $account = $accounts->getByName('Install service test')[0];

        // Account based assertions
        $this->assertEquals('Install service test', $account->getName());
    }

    private function assertDomain()
    {
        // Setup the repository
        $domains = App::make(DomainRepositoryInterface::class);
        $domain = $domains->getAll()[0];

        // Assert
        $this->assertEquals('somehost.com', $domain->getDomain());
    }
}
