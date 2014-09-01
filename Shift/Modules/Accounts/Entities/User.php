<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';

    protected $fillable = ['name'];
}
