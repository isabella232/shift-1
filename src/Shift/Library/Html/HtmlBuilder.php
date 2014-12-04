<?php
namespace Tectonic\Shift\Library\Html;

use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;

class HtmlBuilder extends \Illuminate\Html\HtmlBuilder
{
    /**
     * @var PermissionsService
     */
    private $permissions;

    public function __construct(PermissionsService $permissions)
    {
        $this->permissions = $permissions;
    }

    public function button($value = null, $options = array())
    {
        if (isset($options['permissions'])) {
            if (!$this->allowed($options['permissions'])) return;
        }

        return parent::button($value, $options);
    }
}
