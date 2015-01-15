<?php namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'shift:migrate';

    /**
     * @var string
     */
    protected $description = 'Run the Shift 2 database migrations';

    /**
     * Handle running migrations
     */
    public function handle()
    {

    }
}