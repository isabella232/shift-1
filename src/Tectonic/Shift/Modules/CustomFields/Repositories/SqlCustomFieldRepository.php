<?php namespace Tectonic\Shift\Modules\CustomFields\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\CustomFields\Models\CustomField;

class SqlCustomFieldRepository extends SqlBaseRepository implements CustomFieldRepositoryInterface
{
    public function __construct(CustomField $model)
    {
        $this->setModel($model);
    }

}
