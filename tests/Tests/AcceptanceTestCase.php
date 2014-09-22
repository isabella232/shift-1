<?php

namespace Tests;

use App;
use Route;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
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

        $artisan = $this->app->make('artisan');
        $artisan->call('doctrine:schema:drop');
        $artisan->call('doctrine:schema:create');

        $accountRepository = App::make(AccountRepositoryInterface::class);

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
