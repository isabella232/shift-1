<?php
namespace Tectonic\Shift\Library\Html;

use Illuminate\Html\HtmlBuilder;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;
use View;

class ButtonBuilder
{
    /**
     * @var PermissionsService
     */
    private $permissionsService;

    /**
     * @var HtmlBuilder
     */
    private $htmlBuilder;

    /**
     * @param PermissionsService $permissionsService
     */
    public function __construct(PermissionsService $permissionsService, HtmlBuilder $htmlBuilder)
    {
        $this->permissionsService = $permissionsService;
        $this->htmlBuilder = $htmlBuilder;
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
        $type = array_get($options, 'type', 'primary');

        if (isset($options['icon'])) {
            $icon = $options['icon'];
            $iconClass = 'icon';
        }

        if (isset($options['permissions']) && !$this->permissionsService->allows(Auth::user(), $options['permissions'])) {

        }

        return View::make('shift::html.buttons.link', compact('title', 'url', 'icon', 'iconClass', 'size', 'type'));
    }
}
