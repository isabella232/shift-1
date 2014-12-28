<?php namespace Tectonic\Shift\Modules\Authentication\Commands; 

use Illuminate\Support\Facades\Auth;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\TokenNotFoundException;
use Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface;

class SwitchAccountCommandHandler implements CommandHandlerInterface
{

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\TokenRepositoryInterface
     */
    protected $tokenRepository;

    /**
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface $tokenRepository
     */
    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
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
        $tokenRecord = $this->tokenRepository->getByToken($command->token);

        // 2. If token record does NOT exist, throw exception
        if(!$tokenRecord) {
            throw new TokenNotFoundException;
        }

        // 3. Authenticate user
        $authUser = Auth::loginUsingId($tokenRecord->user_id);

        // 4. Delete token record
        $this->tokenRepository->delete($tokenRecord);

        // 5. Return authenticated user
        return $authUser;
    }
}