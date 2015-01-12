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
        $this->syncMigrations();
        $this->syncConfig();
    }

    protected function syncMigrations()
    {
        $src = realpath(__DIR__ . '/../../migrations');
        $dest = realpath(app_path() . '/../database');

        $command = 'cp -R ' . $src . ' ' . $dest;
        shell_exec(escapeshellcmd($command));
    }

    protected function syncConfig()
    {
        // Explicitly mentioning the file name, as otherwise it copies the whole /config dir (not just the contents)
        $src = realpath(__DIR__ . '/../../../config/shift.php');
        $dest = realpath(app_path() . '/../config');

        $command = 'cp ' . $src . ' ' . $dest;
        shell_exec(escapeshellcmd($command));
    }
}