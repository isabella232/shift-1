<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class UpdateRoleCommand extends Command
{
    /**
     * Stores the slug string.
     *
     * @var string
     */
    public $slug;

    /**
     * Array of translated fields and their language codes.
     *
     * @var array
     */
    public $translated;

    /**
     * Whether the role is the default role for registrations or not.
     *
     * @var boolean
     */
    public $default;

    /**
     * @param string $slug
     * @param array $translated
     */
    public function __construct($slug, $default, $translated)
    {
        $this->slug = $slug;
        $this->default = $default;
        $this->translated = $translated;
    }

    /**
     * Create a new command instance with the slug and input array
     *
     * @param array $input
     * @return static
     */
    public static function withInput($input)
    {
        return new static($input['slug'], $input['default'], $input['translated']);
    }
}
