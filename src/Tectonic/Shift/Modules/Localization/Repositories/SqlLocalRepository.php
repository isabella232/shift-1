<?php namespace Tectonic\Shift\Modules\Localization\Repositories;

use Tectonic\Shift\Library\Support\SqlBaseRepository;
use Tectonic\Shift\Modules\Localization\Models\Locale;

class SqlLocalRepository extends SqlBaseRepository implements LocaleRepositoryInterface
{
    public function __construct(Locale $local)
    {
        $this->model = $local;
    }
}
