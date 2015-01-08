<?php namespace Tectonic\Shift\Modules\Authentication\Commands; 

use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Authentication\AccountSwitcherTokenGenerator;
use Tectonic\Shift\Modules\Authentication\Exceptions\TokenNotFoundException;
use Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface;

class SwitchAccountCommandHandler implements CommandHandlerInterface
{

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\TokenRepositoryInterface
     */
    protected $tokenRepository;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface $tokenRepository
     * @param \Illuminate\Auth\AuthManager                                              $auth
     */
    public function __construct(TokenRepositoryInterface $tokenRepository, AuthManager $auth)
    {
        $this->tokenRepository = $tokenRepository;
        $this->auth            = $auth;
    }

    /**
     * Handle the command.
     *
     * @param $command
     *
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\TokenNotFoundException
     * @return mixed
     */
    public function handle($command)
    {
        // 1. Get token record
        $token = $this->tokenRepository->getByToken($command->token);

        // 2. If token record does NOT exist, throw exception
        if(!$token) {
            throw new TokenNotFoundException;
        }

        // 3. Authenticate user
        $data     = $this->getTokenData($token);
        $authUser = $this->auth->loginUsingId($data->userId);

        // 4. Delete token record
        $this->tokenRepository->delete($token);

        // 5. Return authenticated user
        return $authUser;
    }

    /**
     * Get token data
     *
     * @param $token
     *
     * @return array
     */
    protected function getTokenData($token)
    {
        $generator = new AccountSwitcherTokenGenerator();
        return $generator->decodeData($token->data);
    }
}