<?php

namespace Tests;

use App;
use Route;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

class AcceptanceTestCase extends TestCase
{
    /**
     * Stores the account that is necessary for acceptance and database test cases.
     *
     * @var
     */
    protected $account;

    /**
     * Stores the current account service for easy switching of the current account. This is necessary
     * for when we need to test data that exist as part of other accounts.
     *
     * @var CurrentAccountService
     */
    protected $currentAccountService;

    /**
     * Stores a response created by a call to the API.
     *
     * @var null
     */
    protected $response = null;

    /**
     * Used for the database connection.
     *
     * @var string
     */
    private $database = 'test';

    /**
     * Reset the response.
     */
    public function tearDown()
    {
        $this->response = null;
    }

    /**
     * Configures the default database connection for test runs.
     *
     * @param $app
     */
    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('database.default', $this->database);
        $app['config']->set('database.connections.'.$this->database, array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => ''
        ));
    }

    /**
     * Sets up the required database connection and then runs the migrations.
     */
    public function setUp()
    {
        parent::setUp();

        Route::disableFilters();

        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__ . '/../../';

        $artisan = $this->app->make('artisan');
        $artisan->call('migrate', [
            '--database' => $this->database,
            '--path'     => 'src/migrations'
        ]);

        $this->setupAccount();
    }

    /**
     * Configures the databas for the default account.
     */
    public function setupAccount()
    {
        $accountRepository = App::make(AccountRepositoryInterface::class);

        $this->account = $accountRepository->getNew();

        $accountRepository->save($this->account);

        $this->currentAccountService = App::make(CurrentAccountService::class);
        $this->currentAccountService->set($this->account);
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
