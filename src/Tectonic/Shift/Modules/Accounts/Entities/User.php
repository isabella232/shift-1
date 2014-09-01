<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

use Tectonic\Shift\Library\Support\BaseModel;

class User extends BaseModel
{
	protected $table = 'users';

    protected $fillable = ['name'];
}
