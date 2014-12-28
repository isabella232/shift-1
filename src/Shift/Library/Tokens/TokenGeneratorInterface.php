<?php namespace Tectonic\Shift\Library\Tokens;

interface TokenGeneratorInterface
{
    /**
     * Generate a token, based on the array of given data.
     *
     * @param array $data
     *
     * @return string
     */
    public function generateToken(array $data);

    /**
     * Retrieve an array of all data elements given to the token generator
     *
     * @return mixed
     */
    public function getData();
}