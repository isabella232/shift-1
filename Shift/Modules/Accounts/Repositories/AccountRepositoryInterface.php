<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\BaseRepositoryInterface;

interface AccountRepositoryInterface extends BaseRepositoryInterface
{
	public function requireByDomain($domain);
}
