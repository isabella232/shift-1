<?php
namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;

class ResetCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'shift:reset';

    /**
     * @var string
     */
    protected $description = 'Reset a Shift 2 installation';

    /**
     * Fire the command, running through the following steps:
     *
     *   1. Reset all migrations
     *   2. Reinstall Shift 2
     */
    public function fire()
    {
        $this->call('migrate:reset');
        $this->call('shift:install');
    }
}
