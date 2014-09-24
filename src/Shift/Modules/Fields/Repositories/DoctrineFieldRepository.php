<?php namespace Tectonic\Shift\Modules\Fields\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Fields\Entities\Field;

class DoctrineFieldRepository extends Repository implements FieldRepositoryInterface
{
    protected $entity = Field::class;
}
