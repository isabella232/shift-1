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
     * @param string $slug
     * @param array $translated
     */
    public function __construct($slug, $translated)
    {
        $this->slug = $slug;
        $this->translated = $translated;
    }

    /**
     * Create a new command instance with the slug and input array
     *
     * @param string $slug
     * @param array $input
     * @return static
     */
    public static function withInput($slug, $input)
    {
        return new static($slug, $input['translated']);
    }
}
