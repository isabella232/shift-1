<?php

namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class Domain extends Model
{
    /**
     * Fillable attributes.
     *
     * @var array
     */
    public $fillable = ['domain'];

    /**
     * Domains belong to an account.
     *
     * @return mixed
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
