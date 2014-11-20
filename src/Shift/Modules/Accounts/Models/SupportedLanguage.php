<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Models\Language;

class SupportedLanguage extends Model
{
    use EventGenerator;

    public $fillable = ['accountId', 'languageId'];

	public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Adds a new supported language to an account.
     *
     * @param Account $account
     * @param Language $language
     * @return static
     */
    public static function add(Account $account, Language $language)
    {
        $supportedLanguage = new static;
        $supportedLanguage->account()->associate($account);
        $supportedLanguage->language()->associate($language);
        $supportedLanguage->save();

        $supportedLanguage->raise(new SupportedLanguageAdded($supportedLanguage));

        return $supportedLanguage;
    }
}
