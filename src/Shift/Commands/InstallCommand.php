<?php
namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'shift:install';

    /**
     * @var string
     */
    protected $description = 'Install Shift 2';

    /**
     * Fire the command, running through the following steps:
     *
     *   1. Install the migrations table
     *   2. Migrate the laravel-localisations package
     *   3. Migrate the shift package
     *   4. Publish any and all assets
     *   5. Rebuild the services.json file
     */
    public function fire()
    {
        $this->tryMigrateInstall();

        $this->call('migrate', array('--package' => 'tectonic/shift'));
        $this->call('asset:publish');
        $this->call('shift:compile-services');

        $this->info('Shift installed.');
    }

    private function tryMigrateInstall()
    {
        try {
            $this->call('migrate:install');
        } catch (\Exception $e) {}
    }
}
