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
        Assertion::inArray($type, ['user', 'api', 'guest']);

        $this->type = $type;
    }

    /**
     * Returns true if the consumer type is user.
     *
     * @return bool
     */
    public function user()
    {
        return $this->type == 'user';
    }

    /**
     * Returns true if the consumer type is api.
     *
     * @return bool
     */
    public function api()
    {
        return $this->type == 'api';
    }

    /**
     * Returns true if the consumer type is guest.
     *
     * @return bool
     */
    public function guest()
    {
        return $this->type == 'guest';
    }

    /**
     * Determines whether or not the current consumer type is equal to another.
     *
     * @param ConsumerType $type
     * @return bool
     */
    public function equals(ConsumerType $type)
    {
        return $this == $type;
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
