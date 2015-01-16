<?php
namespace Tectonic\Shift\Controllers;

use App;
use Input;
use Redirect;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\LaravelLocalisation\Facades\Translator;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Commands\CreateAccountCommand;
use Tectonic\Shift\Modules\Accounts\Search\AccountSearch;

class AccountController extends Controller
{
	/**
	 * @var AccountRepositoryInterface
	 */
	private $accountRepository;

	/**
	 * @var ValidationCommandBus
	 */
	private $commandBus;

	/**
	 * @param AccountRepositoryInterface $accountRepository
     */
	public function __construct(ValidationCommandBus $commandBus, AccountRepositoryInterface $accountRepository)
	{
		$this->accountRepository = $accountRepository;
		$this->commandBus = $commandBus;
	}

	/**
	 * Retrieve a list of roles based on the search conditions provided.
	 *
	 * @Get("accounts", middleware={"shift.account", "shift.auth"}, as="accounts.index")
	 *
	 * @return mixed
	 */
	public function getIndex()
	{
		$search = App::make(AccountSearch::class);
		$accounts = Translator::translate($search->fromInput(Input::get()));

		return $this->respond('shift::accounts.index', compact('accounts'));
	}

	/**
	 * Render the form for a new account.
	 *
	 * @Get("accounts/new", middleware={"shift.account", "shift.auth"}, as="accounts.new")
	 *
	 * @return mixed
     */
	public function getNew()
	{
		$account = $this->accountRepository->getNew();

		return $this->respond('shift::accounts.new', compact('account'));
	}

	/**
	 * Create a new account based on the input provided.
	 *
	 * @Post("accounts", middleware={"shift.account", "shift.auth"}, as="accounts.create")
	 *
	 * @return mixed
     */
	public function postStore()
	{
		$command = CreateAccountCommand::fromInput(Input::get());

		$this->commandBus->execute($command);

		return Redirect::route('accounts.index');
	}

	/**
	 * Retrieve a single account based on the slug provided.
	 *
	 * @Get("accounts/{slug}", middleware={"shift.account", "shift.auth"}, as="accounts.show")
	 *
	 * @param $slug
	 */
	public function getShow($slug)
	{
		$account = Translator::translate($this->accountRepository->requireBySlug($slug));

		return $this->respond('shift::accounts.edit', compact('account'));
	}
}
