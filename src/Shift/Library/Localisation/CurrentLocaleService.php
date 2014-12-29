<?php
namespace Tectonic\Shift\Library\Localisation;

use Tectonic\Shift\Library\Facades\Consumer;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

class CurrentLocaleService
{
    /**
     * @var string
     */
    private $language;

    /**
     * Determines the current language/locale based on consumer settings.
     *
     * @return Language
     */
	protected function determine()
    {
        return Consumer::language();
    }

    /**
     * Retrieves the current locale.
     *
     * @return Language
     */
    public function language()
    {
        if (!$this->language) {
            $this->language = $this->determine();
        }

        return $this->language;
    }

    /**
     * Returns the language code for the current locale determined for the user.
     *
     * @return string
     */
    public function code()
    {
        return $this->language()->code;
    }
}
