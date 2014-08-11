<?php

namespace Tectonic\Shift\Modules\Accounts\Models;

use Tectonic\Shift\Library\Support\BaseModel;

class Domain extends BaseModel
{
	protected $table = 'domains';

    protected $fillable = ['domain'];

	/**
	 * Each domain belongs to one account.
	 *
	 * @return mixed
	 */
	public function account()
	{
		return $this->belongsTo('Tectonic\Shift\Modules\Accounts\Models\Account');
	}
}
