<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class SetupDefaultRolesCommandHandler implements CommandHandlerInterface
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $this->setupAdmin($command->account);
        $this->setupUser($command->account);
    }

    /**
     * Create the admin role for the account.
     *
     * @param Account $account
     */
    private function setupAdmin(Account $account)
    {
        $administrator = Role::create([]);
        $administrator->setAccount($account);

        $this->roleRepository->save($administrator);
    }

    /**
     * Setup the user role for the account.
     *
     * @param Account $account
     */
    private function setupUser(Account $account)
    {
        $guest = Role::create([]);
        $guest->setAccount($account);

        $this->roleRepository->save($guest);
    }
}
