<?php namespace Tectonic\Shift\Modules\Localisation\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\Localisation\Models\Localisation;

class SqlLocalisationRepository extends SqlBaseRepository implements LocalisationRepositoryInterface
{
    public function __construct(Localisation $localisation)
    {
        $this->model = $localisation;
    }
}
