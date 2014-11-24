<?php
namespace Tectonic\Shift\Library\Composers;

use App;
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
     * @var CurrentAccountService
     */
    private $currentAccountService;

    /**
     * @param StartupService $startupService
     */
    function __construct(StartupService $startupService, CurrentAccountService $currentAccountService)
    {
        $this->startupService = $startupService;
        $this->currentAccountService = $currentAccountService;
    }

    public function compose($view)
	{
        $configuration = $this->startupService->configuration();

		$view->share('configuration', $configuration);
        $view->share('account', $this->currentAccountService->get());
	}
}
