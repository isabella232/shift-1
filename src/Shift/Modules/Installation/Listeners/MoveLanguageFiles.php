<?php
namespace Tectonic\Shift\Modules\Installation\Listeners;

use Tectonic\Application\Eventing\EventListener;
use Tectonic\Shift\Modules\Accounts\Events\AccountWasInstalled;

class MoveLanguageFiles extends EventListener
{
	public function whenAccountWasInstalled(AccountWasInstalled $account)
    {
        $langPath = app_path('lang');
        $enPath = "$langPath/en";
        $enGbPath = "$langPath/en_GB";

        if (File::exists($enPath)) {
            File::move($enPath, $enGbPath);
        }
    }
}
