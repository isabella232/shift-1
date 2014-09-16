<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface AccountRepositoryInterface extends RepositoryInterface
{
	public function requireByDomain($domains);
}
