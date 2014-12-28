<?php namespace Tectonic\Shift\Library\Tokens;

class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Generate a token, based on the array of given data.
     *
     * @param array $data
     *
     * @return string
     */
    public function generateToken(array $data)
    {
        return $this->generate($data);
    }

    /**
     * Retrieve an array of all data elements given to the token generator
     *
     * @return mixed
     */
    public function getData()
    {
        return json_encode($this->data);
    }

    /**
     * Generate a token string
     *
     * @param $data
     *
     * @return string
     */
    protected function generate($data)
    {
        $string = implode("", array_values($data));

        return md5($string);
    }
}