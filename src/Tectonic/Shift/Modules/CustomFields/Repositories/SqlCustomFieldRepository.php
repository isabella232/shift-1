<?php namespace Tectonic\Shift\Modules\CustomFields\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\EloquentBaseRepository;
use Tectonic\Shift\Modules\CustomFields\Models\CustomField;

class EloquentCustomFieldRepository extends EloquentBaseRepository implements CustomFieldRepositoryInterface
{
    public function __construct(CustomField $model)
    {
        $this->setModel($model);
    }

}
