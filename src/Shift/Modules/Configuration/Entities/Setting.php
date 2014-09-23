<?php namespace Tectonic\Shift\Modules\Configuration\Entities;

use Doctrine\ORM\Mapping as ORM;
use Tectonic\Shift\Modules\Accounts\Entities\Accountable;

/**
 * Class Setting
 *
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Configuration\Repositories\DoctrineSettingRepository")
 * @ORM\Table(name="settings")
 */
class Setting
{
    use Accountable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="`key`")
     */
    protected $key;

    /**
     * @ORM\Column(type="string", name="`value`")
     */
    protected $value;

    /**
     * Every setting must have a key and value properties.
     *
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
