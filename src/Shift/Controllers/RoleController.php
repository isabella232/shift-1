<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Tectonic\Shift\Library\Support\Controller;
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

    public function __construct(RoleSearch $search, RoleService $rolesService)
	{
        $this->search = $search;
        $this->rolesService = $rolesService;
    }

    /**
     * Retrieve a list of roles based on the search conditions provided.
     *
     * @return mixed
     */
    public function getIndex()
    {
        $roles = $this->search->fromInput(Input::get());

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
}
