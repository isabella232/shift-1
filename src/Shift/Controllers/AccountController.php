<?php
namespace Tectonic\Shift\Controllers;

use App;
use Input;
use Tectonic\LaravelLocalisation\Facades\Translator;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Search\AccountSearch;

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
		$accounts = Translator::translate($search->fromInput(Input::get()));

		return $this->respond('shift::accounts.index', compact('accounts'));
	}
}
