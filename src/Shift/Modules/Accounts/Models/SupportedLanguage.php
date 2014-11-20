<?php
namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class SupportedLanguage extends Model
{
    use EventGenerator;

    public $fillable = ['code'];

	public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
