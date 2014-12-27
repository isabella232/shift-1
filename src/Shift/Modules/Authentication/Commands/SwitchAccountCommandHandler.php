<?php namespace Tectonic\Shift\Modules\Authentication\Commands; 

use Illuminate\Support\Facades\Auth;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Authentication\Models\AccountSwitch;
use Tectonic\Shift\Modules\Authentication\Exceptions\AccountSwitchTokenNotFoundException;

class SwitchAccountCommandHandler implements CommandHandlerInterface
{
    /**
     * Handle the command.
     *
     * @param $command
     *
     * @return
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\AccountSwitchTokenNotFoundException
     */
    public function handle($command)
    {
        // 1. Get token record
        $tokenRecord = AccountSwitch::where('token', '=', $command->token)->first();

        // 2. If token record does NOT exist, throw exception
        if(!$tokenRecord) throw new AccountSwitchTokenNotFoundException;

        // 3. Authenticate user
        $authUser = Auth::loginUsingId($tokenRecord->user_id);

        // 4. Delete token record
        $tokenRecord->delete();

        // 5. Return authenticated user
        return $authUser;
    }
}