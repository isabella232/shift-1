<?php namespace Tectonic\Shift\Modules\CustomFields\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\CustomFields\Models\CustomField;

class EloquentCustomFieldRepository extends Repository implements CustomFieldRepositoryInterface
{
    public function __construct(CustomField $model)
    {
        $this->setModel($model);
    }

}
