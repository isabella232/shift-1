<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Tectonic\LaravelLocalisation\Facades\Translator;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Library\Support\DefaultResponder;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Search\RoleSearch;
use Tectonic\Shift\Modules\Identity\Roles\Services\RoleService;

class RoleController extends Controller
{
    /**
     * @var RoleSearch
     */
    private $search;

    /**
     * @var RolesService
     */
    private $rolesService;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param RoleSearch $search
     * @param RoleService $rolesService
     */
    public function __construct(RoleSearch $search, RoleService $rolesService, RoleRepositoryInterface $roleRepository)
	{
        $this->search = $search;
        $this->rolesService = $rolesService;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Retrieve a list of roles based on the search conditions provided.
     *
     * @return mixed
     */
    public function getIndex()
    {
        $roles = Translator::translate($this->search->fromInput(Input::get()));

        return $this->respond('shift::roles.index', compact('roles'));
    }

    /**
     * Renders the form required for creating a new role.
     */
    public function getNew()
    {
        $role = new Role;

        return $this->respond('shift::roles.new', compact('role'));
    }

    /**
     * Creates a new role based on the information provided by the user.
     */
    public function postStore()
    {
        return $this->rolesService->create(Input::get(), new DefaultResponder('roles'));
    }

    /**
     * Retrieve a single role.
     */
    public function getShow($roleSlug)
    {
        $role = Translator::translate($this->roleRepository->requireBy('slug', $roleSlug));

        return $this->respond('shift::roles.edit', compact('role'));
    }
}
