<?php
namespace Tests\Acceptance\Modules\Installation\Services;

use App;
use CurrentAccount;
use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Installation\Services\InstallService;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tests\AcceptanceTestCase;
use Tests\Stubs\InstallationResponder;

class InstallServiceTest extends AcceptanceTestCase
{
    private $input, $accountRepository;
    private $supportedLanguageRepository;

    public function init()
    {
        $languageRepository = App::make(LanguageRepositoryInterface::class);

        $this->input = [
            'name' => 'Install service test',
            'host' => 'somehost.com',
            'email' => 'installer@tectonic.com.au',
            'language' => $languageRepository->getAll()->first()->code,
            'password' => '1234'
        ];

        $installService = App::make(InstallService::class);
        $installService->freshInstall($this->input, new InstallationResponder);

        $this->accountRepository = App::make(AccountRepositoryInterface::class);
        $this->supportedLanguageRepository = App::make(SupportedLanguageRepositoryInterface::class);

        $newAccount = $this->accountRepository->getAll()[1];
    }

	public function testUserCreation()
    {
        // Setup the repository
        $users = App::make(UserRepositoryInterface::class);
        $user = $users->getAll()[0];

        // User assertions
        $this->assertEquals('Super', $user->firstName);
        $this->assertEquals('Admin', $user->lastName);
    }

    public function testAccountCreation()
    {
        $account = CurrentAccount::get();

        // Account based assertions
        $this->assertEquals($this->input['name'], $account->translations->first()->value);
    }

    public function testUserAccountRelationshipCreation()
    {
        $account = CurrentAccount::get();

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
        $this->assertEquals($this->input['host'], $domain->domain);
    }
}

