<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\DoctrineBaseRepository;

class DoctrineAccountRepository extends DoctrineBaseRepository implements AccountRepositoryInterface
{
    public function requireByDomain($domain)
    {
        $this->_em->find
    }
}
