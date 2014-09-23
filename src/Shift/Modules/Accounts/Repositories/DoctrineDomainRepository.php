<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Entities\Domain;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Accounts\ValueObjects\DomainName;

class DoctrineDomainRepository extends Repository implements DomainRepositoryInterface
{
	/**
	 * Required entity setting.
	 *
	 * @var string
	 */
	protected $entity = Domain::class;

    /**
     * Domains require a special value object in order to do their work, so we must overload
     * the default getNew method and provide our own implementation.
     *
     * @param array $data
     */
    public function getNew(array $data = [])
    {
        $domain = new Domain($data['account'], new DomainName($data['domain']));

        return $domain;
    }
}
