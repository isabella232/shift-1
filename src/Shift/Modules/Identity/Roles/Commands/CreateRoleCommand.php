<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class CreateRoleCommand extends Command
{
    /**
     * @var
     */
    private $nameTranslations;

    public function __construct($nameTranslations)
    {
        $this->nameTranslations = $nameTranslations;
    }
}
