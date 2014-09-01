<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;

class DoctrineAccountRepository extends Repository implements AccountRepositoryInterface
{
    public function requireByDomain($domain)
    {
        $this->entityManager()->findOneByDomain($domain);
    }
}
