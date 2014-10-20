<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Models\Domain;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class EloquentDomainRepository extends Repository implements DomainRepositoryInterface
{
	/**
	 * Accounts are the top-level root domain of the entire system. Therefore, they are removed
	 * from the default account restriction for querying.
	 *
	 * @var bool
	 */
	public $restrictByAccount = false;

    /**
     * Make sure we assign the rqeuired model.
     *
     * @param Account $model
     */
    public function __construct(Domain $model)
    {
        $this->model = $model;
    }
}
