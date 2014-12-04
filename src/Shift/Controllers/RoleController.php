<?php
namespace Tectonic\Shift\Controllers;

use Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Identity\Roles\Search\RoleSearch;

class RoleController extends Controller
{
    /**
     * @var RoleSearch
     */
    private $search;

    public function __construct(RoleSearch $search)
	{
        $this->search = $search;
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
}
