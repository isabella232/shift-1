<?php
namespace Tectonic\Shift\Library\Authorization;

interface ConsumerInterface
{
    /**
     * Returns an array of accounts that the consumer can manage.
     *
     * @return array Account
     */
    public function accounts();

    /**
     * Returns the language that the consumer prefers.
     *
     * @return Language
     */
    public function language();

    /**
     * Return the id for the consumer.
     *
     * @return integer
     */
    public function id();

    /**
     * Returns the type of the consumer.
     *
     * @return ConsumerType
     */
    public function type();
}
