<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class CreateRoleCommand extends Command
{
    /**
     * @var array
     */
    public $translated;

    /**
     * @param array $translated
     */
    public function __construct(array $translated)
    {
        $this->translated = $translated;
    }
}
