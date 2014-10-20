<?php namespace Tectonic\Shift\Modules\Fields\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Fields\Entities\Field;

class DoctrineFieldRepository extends Repository implements FieldRepositoryInterface
{
    protected $entity = Field::class;

    /**
     * Creates a new Field instance.
     *
     * @param array $data
     * @return Setting
     */
    public function getNew(array $data = [])
    {
        $field = new Field($data['resource'], $data['type']);

        return $this->decorate($field, $data);
    }
}
