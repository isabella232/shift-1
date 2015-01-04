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
     * @var
     */
    private $default;

    /**
     * @param array $translated
     */
    public function __construct($default, array $translated)
    {
        $this->translated = $translated;
        $this->default = $default;
    }

    /**
     * Create a new command instance based on user input.
     *
     * @param array $input
     * @return static
     */
    public static function withInput(array $input)
    {
        return new static($input['default'], $input['translated']);
    }
}
