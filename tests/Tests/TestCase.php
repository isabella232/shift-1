<?php

namespace Tests;

use App;
use DB;
use Illuminate;
use Mockery as m;
use Symfony;
use Route;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

class TestCase extends \Orchestra\Testbench\TestCase
{
	private $database = 'test';
	protected $account;

	/**
     * Stores a response created by a call to the API.
     *
     * @var null
     */
    protected $response = null;

	public function tearDown()
	{
		m::close();

        $this->response = null;
	}

	protected function getPackageProviders()
	{
		return [
            'Tectonic\Shift\ShiftServiceProvider'
        ];
	}

	/**
	 * Define environment setup.
	 *
	 * @param  Illuminate\Foundation\Application $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		// reset base path to point to our package's src directory
		$app['path.base'] = __DIR__ . '/../../';

		$app['config']->set('database.default', $this->database);
		$app['config']->set('database.connections.'.$this->database, array(
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => ''
		));
	}

    protected function getPackageAliases()
    {
        return [
            'Validator' => 'Illuminate\Support\Facades\Validator'
        ];
    }

	public function setUp()
	{
		parent::setUp();

        Route::disableFilters();

		$artisan = $this->app->make('artisan');
		$artisan->call('doctrine:schema:drop');
		$artisan->call('doctrine:schema:create');

		$accountRepository = App::make('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface');

		$this->account = $accountRepository->getNew(['name' => 'Test account', 'userId' => 1]);

		$accountRepository->save($this->account);

		$accountService = App::make(CurrentAccountService::class);
		$accountService->setCurrentAccount($this->account);
	}

    /**
     * Most calls will return a JSON response. This method simply decodes
     * the response which you can use to validate the data returned.
     *
     * @param boolean $asArray
     * @param mixed $response
     * @return mixed
     */
    protected function parseResponse($asArray = false, $response = null)
    {
        if (is_null($response)) {
            $response = $this->response->getContent();
        }

	    $json = json_decode($response, $asArray);

	    return $json;
    }
}
