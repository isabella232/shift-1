<?php namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SyncCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'shift:sync';

    /**
     * @var string
     */
    protected $description = 'Sync the Shift 2 resources (migration, configuration and language files)';

    /**
     * Handle running migrations
     */
    public function handle()
    {
        $src  = realpath(__DIR__.'/../../migrations');
        $dest = realpath(app_path() . '/../database');

        $command = 'cp -a ' . $src . ' ' . $dest;
        shell_exec(escapeshellcmd($command));
    }
}