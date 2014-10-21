<?php
namespace Tectonic\Shift\Modules\Localisation\Listeners;

use Tectonic\Shift\Library\Support\Listener;
use Tectonic\Shift\Modules\Localisation\Services\LocaleManagementService;

class AccountInstalled extends Listener
{
    /**
     * @return array
     */
    public function hooks()
    {
        return [
            'account.installed' => 'associateLocale'
        ];
    }

    /**
     * @param $account
     */
    public function associateLocale($account)
    {
        $this->locale
    }
}
 