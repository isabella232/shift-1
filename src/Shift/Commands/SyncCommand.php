<?php namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
    protected $description = 'Sync the Shift 2 resources (migration, configuration and asset files)';

    /**
     * Handle running migrations
     */
    public function handle()
    {
        $this->syncMigrations();
        $this->syncConfig();
        $this->syncAssets();
        $this->syncLangFiles();
    }

    protected function syncMigrations()
    {
        $src = realpath(__DIR__ . '/../../../resources/migrations');
        $dest = realpath(app_path() . '/../database');

        $command = "cp -Rf $src $dest";

        shell_exec(escapeshellcmd($command));

        $this->info('Synchronised migrations.');
    }

    protected function syncConfig()
    {
        // Explicitly mentioning the file name, as otherwise it copies the whole /config dir (not just the contents)
        $src = realpath(__DIR__.'/../../../config/shift.php');
        $dest = realpath(app_path().'/../config');

        $command = "cp $src $dest";

        shell_exec(escapeshellcmd($command));

        $this->info('Synchronised configuration.');
    }

    protected function syncAssets()
    {
        $src  = realpath(__DIR__ . '/../../../resources/public');
        $dest = realpath(public_path().'/../');

        $command = "cp -Rf $src $dest";

        shell_exec(escapeshellcmd($command));

        $this->info('Synchronised assets.');
    }

    protected function syncLangFiles()
    {
        $this->setupLangDir();

        $src  = realpath(__DIR__.'/../../../resources/lang');
        $dest = realpath(public_path().'/../resources');

        $command = "cp -Rf $src $dest";

        shell_exec(escapeshellcmd($command));

        $this->info('Synchronised language files.');
    }

    protected function setupLangDir()
    {
        $langDir = realpath(app_path().'/../resources/lang');

        if (File::exists("$langDir/en")) {
            File::move("$langDir/en", "$langDir/en_GB");
        }
    }
}