<?php namespace Tectonic\Shift\Library\Tokens;

interface TokenGeneratorInterface
{
    /**
     * Generate a token, based on the array of given data.
     *
     * @return string
     */
    public function generateToken();

    /**
     * Encode the data array and return as string.
     *
     * @return string
     */
    public function encodeData();

    /**
     * Decode the data string, and return as an array
     *
     * @param string $data
     *
     * @return mixed
     */
    public function decodeData($data);
}