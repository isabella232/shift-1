<?php
namespace Tectonic\Shift\Library\Support;

use App;
use Input;
use Request;
use Response;
use Tectonic\Shift\Library\BaseValidator;
use Tectonic\Shift\Library\SqlBaseRepositoryInterface;
use Tectonic\Shift\Library\Traits\Respondable;
use View;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use Respondable;

    /**
     * Setup the layout that may be required for the view.
     */
    protected function setupLayout()
    {
        if ($this->isFullPage()) {
            $this->layout = view('shift::layouts.fullpage');
        }
        else if ($this->isPjax()) {
            $this->layout = view('shift::layouts.pjax');
        }
    }
}
