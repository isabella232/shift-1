<?php
namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Domain;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class EloquentDomainRepository extends Repository implements DomainRepositoryInterface
{
    /**
     * Make sure we assign the required model.
     *
     * @param \Tectonic\Shift\Modules\Accounts\Models\Domain $model
     */
    public function __construct(Domain $model)
    {
        $this->model = $model;
    }
}
