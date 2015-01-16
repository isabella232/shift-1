<?php
namespace Tectonic\Shift\Controllers;

use App;
use Input;
use Redirect;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\LaravelLocalisation\Facades\Translator;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Identity\Roles\Commands\CreateRoleCommand;
use Tectonic\Shift\Modules\Identity\Roles\Commands\UpdateRoleCommand;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Search\RoleSearch;
use Tectonic\Shift\Modules\Identity\Roles\Services\RoleService;

class RoleController extends Controller
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

    /**
     * @param RoleSearch $search
     * @param RoleService $rolesService
     */
    public function __construct(
        ValidationCommandBus $commandBus,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->commandBus = $commandBus;
    }

    /**
     * Retrieve a list of roles based on the search conditions provided.
     *
     * @Get("roles", middleware={"shift.account", "shift.auth"}, as="roles.index")
     *
     * @return mixed
     */
    public function getIndex()
    {
        $search = App::make(RoleSearch::class);
        $roles = Translator::translate($search->fromInput(Input::get()));

        return $this->respond('shift::roles.index', compact('roles'));
    }

    /**
     * Renders the form required for creating a new role.
     *
     * @Get("roles/new", middleware={"shift.account", "shift.auth"}, as="roles.new")
     */
    public function getNew()
    {
        $role = $this->roleRepository->getNew();

        return $this->respond('shift::roles.new', compact('role'));
    }

    /**
     * Creates a new role based on the information provided by the user.
     *
     * @Post("roles", middleware={"shift.account", "shift.auth"}, as="roles.create")
     */
    public function postStore()
    {
        $command = CreateRoleCommand::withInput(Input::get());

        $this->commandBus->execute($command);

        return Redirect::route('roles.index');
    }

    /**
     * Retrieve a single role.
     *
     * @Get("roles/{slug}", middleware={"shift.account", "shift.auth"}, as="roles.show")
     *
     * @param $slug
     *
     * @return mixed
     */
    public function getShow($slug)
    {
        $role = Translator::translate($this->roleRepository->requireBySlug($slug));

        return $this->respond('shift::roles.edit', compact('role'));
    }

    /**
     * Manage the updating of a specific role, based on the slug provided.
     *
     * @Put("roles/{slug}", middleware={"shift.account", "shift.auth"}, as="roles.update")
     *
     * @param string $slug
     * @return mixed
     */
    public function putUpdate($slug)
    {
        $input = Input::get();
        $input['slug'] = $slug;

        $command = UpdateRoleCommand::withInput($input);

        $this->commandBus->execute($command);

        return Redirect::route('roles.index');
    }
}
