<?php
namespace Tectonic\Shift\Library\Authorization;


use Assert\Assertion;

class ConsumerType
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param $type
     */
    public function __construct($type)
    {
        Assertion::inArray($type, ['user', 'api']);

        $this->type = $type;
    }

    /**
     * Return the type value for string output.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->type;
    }
}
