<?php
namespace Tests\Integrated\Modules\Authentication;

use App;
use Mockery as m;
use Tests\IntegratedTestCase;
use Illuminate\Support\Facades\DB;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;
use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;

class AuthenticationServiceTest extends IntegratedTestCase
{
    protected $service;

    public function init()
    {
        $this->service = App::make(AuthenticationService::class);
    }

    public function testValidationFailureOnLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Act
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => '',                  // Missing password, should cause validation failure.
            'remember' => false
        ], $observer);

        // Assert.
        $observer->shouldHaveReceived('onValidationFailure')->once();
    }

    public function testAuthenticationFailureOnLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Act (Incorrect email & password combination should cause authentication failure. In this example no users exist)
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => 'password',
            'remember' => false
        ], $observer);

        // Assert.
        $observer->shouldHaveReceived('onAuthenticationFailure')->once();
    }

    public function testUserAccountFailureLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Create a new user, that isn't associated with the current account.
        $user = $this->createTempUser();

        // Act (User not associated with current account, so it should cause a UserAccountAssociation exception)
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => 'password',
            'remember' => false
        ], $observer);

        // Assert.
        $this->assertSame(1, (int)$user->id);

        $observer->shouldHaveReceived('onUserAccountFailure')->once();
    }

    public function testOnSuccessfulLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Create a new user.
        $user = $this->createTempUser();

        // Associate user with this account.
        $currentAccount = CurrentAccount::get();
        DB::table('account_user')->insert(['account_id' => $currentAccount->id, 'user_id' => $user->id]);

        // Act (User not associated with current account, so it should cause a UserAccountAssociation exception)
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => 'password',
            'remember' => false
        ], $observer);

        // Assert.
        $this->assertSame(1, (int)$user->id);

        $observer->shouldHaveReceived('onSuccess')->once();
    }

    private function createTempUser()
    {
        $userRepository = App::make(UserRepositoryInterface::class);

        $user = $userRepository->getNew();

        $user->first_name = "Test";
        $user->last_name = "User";
        $user->email = "email@address.dev";
        $user->password = 'password';

        $userRepository->save($user);

        return $userRepository->getByEmail($user->email);
    }

}