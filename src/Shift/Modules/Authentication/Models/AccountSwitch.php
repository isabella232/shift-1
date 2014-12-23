<?php namespace Tectonic\Shift\Modules\Authentication\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class AccountSwitch extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'account_switches';

    /**
     * Fillable attributes
     *
     * @var array
     */
    public $fillable = ['account_id', 'user_id', 'token'];
}