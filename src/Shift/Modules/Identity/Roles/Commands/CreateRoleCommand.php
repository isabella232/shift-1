<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class CreateRoleCommand extends Command
{
    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}
