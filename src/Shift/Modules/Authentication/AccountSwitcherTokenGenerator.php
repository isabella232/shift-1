<?php namespace Tectonic\Shift\Modules\Authentication;

use Tectonic\Shift\Library\Tokens\TokenGeneratorInterface;

class AccountSwitcherTokenGenerator implements TokenGeneratorInterface
{

    /**
     * @var array
     */
    public $data;

    /**
     * @param $toAccount
     * @param $fromAccount
     * @param $userId
     */
    public function setData($toAccount, $fromAccount, $userId)
    {
        $this->data = [
            'toAccount'   => $toAccount,
            'fromAccount' => $fromAccount,
            'userId'      => $userId
        ];
    }

    /**
     * Generate a token, based on the array of given data.
     *
     * @return string
     */
    public function generateToken()
    {
        $string = implode("", array_values($this->data));

        return md5($string);
    }

    /**
     * Encode the data array and return as string.
     *
     * @return string
     */
    public function encodeData()
    {
        return json_encode($this->data);
    }

    /**
     * Decode the data string, and return as an array
     *
     * @param string $data
     *
     * @return mixed
     */
    public function decodeData($data)
    {
        return json_decode($data);
    }
}