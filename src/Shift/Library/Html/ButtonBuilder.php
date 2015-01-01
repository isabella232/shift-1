<?php
namespace Tectonic\Shift\Library\Html;

use Auth;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;
use View;

class ButtonBuilder
{
    /**
     * @var PermissionsService
     */
    private $permissionsService;

    /**
     * @param PermissionsService $permissionsService
     */
    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return mixed
     */
    public function link($url, $title, array $options = [])
    {
        $icon = '';
        $iconClass = '';
        $size = array_get($options, 'size', 'big');
        $type = array_get($options, 'type', '');

        if (isset($options['icon'])) {
            $icon = $options['icon'];
            $iconClass = 'icon';
        }

        if (isset($options['permissions']) && false === $this->permitted($options['permissions'])) {
            return;
        }

        return View::make('shift::html.buttons.link', compact('title', 'url', 'icon', 'iconClass', 'size', 'type'));
    }

    /**
     * Determine whether or not the user is permitted to view the element. This is based on the permissions
     * element of the array, the required permissions, and the resource/action we're checking against.
     *
     * @param array $permissions
     * @return bool
     */
    protected function permitted(array $permissions)
    {
        return $this->permissionsService->permits($permissions);
    }
}
