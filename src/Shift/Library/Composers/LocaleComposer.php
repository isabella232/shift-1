<?php
namespace Tectonic\Shift\Library\Composers;

use Illuminate\Support\Facades\App;
use Tectonic\Shift\Library\Facades\CurrentLocale;

/**
 * Class LocaleComposer
 *
 * Simply defines the language and locale to be used for all translations within the interface.
 *
 * @package Tectonic\Shift\Library\Composers
 */
class LocaleComposer
{
	public function compose()
    {
        App::setLocale(CurrentLocale::code());
    }
}
