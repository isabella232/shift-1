<?php

namespace Tests\Stubs;

use Tests\Stubs\DoctrineEntityStub;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;

class DoctrineRepositoryStub extends Repository
{
    protected $entity = DoctrineEntityStub::class;
}
