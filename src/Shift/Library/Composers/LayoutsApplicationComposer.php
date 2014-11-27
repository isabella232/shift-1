<?php
namespace Tectonic\Shift\Library\Composers;

use App;
use CurrentAccount;
use Config;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Startup\StartupService;

class LayoutsApplicationComposer
{
    /**
     * @var StartupService
     */
    private $startupService;

    /**
     * @param StartupService $startupService
     */
    function __construct(StartupService $startupService)
    {
        $this->startupService = $startupService;
    }

    public function compose($view)
	{
        $configuration = $this->startupService->configuration();

		$view->share('configuration', $configuration);
        $view->share('account', CurrentAccount::get());
	}
}
