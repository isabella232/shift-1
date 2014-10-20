<?php namespace Tectonic\Shift\Library\Support;

use Hashids\Hashids;

class Slug extends Hashids
{
    /**
     * Salt to use when hashing (creating unique slug).
     *
     * @var string
     */
    protected $salt = '';

    /**
     * Slug length.
     *
     * @var int
     */
    protected $length = 8;

    /**
     * A string of valid characters to generate slug from.
     *
     * @var string
     */
    protected $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Constructor
     *
     * @param string $salt
     * @param int $length
     * @param string $alphabet
     */
    public function __construct($salt = '', $length = 8, $alphabet = '')
    {
        $this->setProperties($salt, $length, $alphabet);

        parent::__construct($this->salt, $this->length, $this->alphabet);
    }

    /**
     * Set class properties.
     *
     * @param $salt
     * @param $length
     * @param $alphabet
     *
     * @return void
     */
    protected function setProperties($salt, $length, $alphabet)
    {
        $this->salt = $salt;
        $this->length = $length;

        if($alphabet !== '') $this->alphabet = $alphabet;
    }
}