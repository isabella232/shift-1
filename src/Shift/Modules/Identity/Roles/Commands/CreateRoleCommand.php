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

    /**
     * Create a new command instance based on user input.
     *
     * @param array $input
     * @return static
     */
    public static function withInput(array $input)
    {
        return new static($input['translated']);
    }
}
