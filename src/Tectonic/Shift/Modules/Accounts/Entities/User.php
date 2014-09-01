<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Tectonic\Shift\Library\Support\Database\Eloquent\BaseModel;

class User extends BaseModel
{
	protected $table = 'users';

    protected $fillable = ['name'];
}
