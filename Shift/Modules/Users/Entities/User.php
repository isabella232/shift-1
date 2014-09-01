<?php

namespace Tectonic\Shift\Modules\Users\Entities;

use Tectonic\Shift\Library\Authorization\UserInterface;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

class User extends Entity implements UserInterface
{
	/**
	 * @TODO
	 *
	 * @return int
	 */
	public function getId()
	{
		return 0;
	}
}
