<?php
namespace Tests\Acceptance\Modules\Installation\Services;

use App;
use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Installation\Services\InstallService;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tests\AcceptanceTestCase;
use Tests\Stubs\InstallationObserver;

class InstallServiceTest extends AcceptanceTestCase
{
    private $input, $accountRepository;
    private $supportedLanguageRepository;

    public function setUp()
    {
        parent::setUp();

        $languageRepository = App::make(LanguageRepositoryInterface::class);

        $this->input = [
            'name' => 'Install service test',
            'host' => 'somehost.com',
            'email' => 'installer@tectonic.com.au',
            'language' => $languageRepository->getAll()->first()->getId(),
            'password' => '1234'
        ];

        $installService = App::make(InstallService::class);
        $installService->freshInstall($this->input, new InstallationObserver);

        $this->accountRepository = App::make(AccountRepositoryInterface::class);
        $this->supportedLanguageRepository = App::make(SupportedLanguageRepositoryInterface::class);

        $newAccount = $this->accountRepository->getAll()[1];

        // set the new current account
        $this->currentAccountService->set($newAccount);
    }

	public function testUserCreation()
    {
        // Setup the repository
        $users = App::make(UserRepositoryInterface::class);
        $user = $users->getAll()[0];

        // User assertions
        $this->assertEquals('Super', $user->getFirstName());
        $this->assertEquals('Admin', $user->getLastName());
    }

    public function testAccountCreation()
    {
        $account = $this->currentAccountService->get();
        $languages = $this->supportedLanguageRepository->getByAccountId($account->getId());

        // Account based assertions
        $this->assertEquals($this->input['name'], $account->getName());
    }

    public function testUserAccountRelationshipCreation()
    {
        $account = $this->currentAccountService->get();

        $users = App::make(UserRepositoryInterface::class);
        $user = $users->getAll()[0];

        $this->assertTrue($user->ownerOf($account));
    }

    public function testDomainCreation()
    {
        // Setup the repository
        $domains = App::make(DomainRepositoryInterface::class);
        $domain = $domains->getAll()[0];

        // Assert
        $this->assertEquals($this->input['host'], $domain->getDomain());
    }
}

