<?php
namespace Tectonic\Shift\Modules\Localisation\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'shift.translator'; }
}
