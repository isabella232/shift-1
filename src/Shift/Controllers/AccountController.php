<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;

class AccountController extends Controller
{
	/**
	 * Retrieve a list of roles based on the search conditions provided.
	 *
	 * @return mixed
	 */
	public function getIndex()
	{
		$search = App::make(AccountSearch::class);
		$roles = Translator::translate($search->fromInput(Input::get()));

		return $this->respond('shift::accounts.index', compact('roles'));
	}
}
