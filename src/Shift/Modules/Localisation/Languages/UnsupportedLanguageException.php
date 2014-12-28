<?php
namespace Tectonic\Shift\Modules\Localisation\Languages;

class UnsupportedLanguageException extends \Exception
{
	public function __construct($code)
    {
        $this->message = 'The requested language code ['.$code.'] is not supported by this application.';
    }
}
