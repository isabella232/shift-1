<?php
namespace Tectonic\Shift\Library\Localisation;

use Consumer;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Localisation\Languages\Language;

class CurrentLocaleService
{
    /**
     * @var string
     */
    private $language;

    /**
     * Determines the current account based on consumer settings.
     *
     * @return string
     */
	protected function determine()
    {
        $currentAccount = CurrentAccount::get();
        $supportedLanguageCodes = $currentAccount->languages->pluck('code');
        $preferredLanguageCode = Consumer::language()->code;

        if (in_array($preferredLanguageCode, $supportedLanguageCodes)) {
            $this->language = new Language($preferredLanguageCode);
        }
        else {
            $this->language = new Language($currentAccount->defaultLanguage());
        }

        return $this->language;
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
