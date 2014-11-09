<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Models\Language;

class SupportedLanguage extends Model
{
    public $fillable = ['accountId', 'languageId'];

	public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
