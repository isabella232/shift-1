<?php
namespace Tectonic\Shift\Library;

/**
 * Class Recaptcha
 *
 * The following class is simply an OO wrapper for the recaptcha library found in src/vendor, to allow
 * for our unit tests and other associated tests to work as expected, without hitting the google
 * servers/services.
 *
 * @package Tectonic\Shift\Library
 */
class Recaptcha
{
    /**
     * URL for verifying a user's captcha response.
     *
     * @var string
     */
    private $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * The key to be used for any api checks or requests.
     *
     * @var string
     */
    protected $privateKey;

    /**
     * @param string $privateKey
     */
    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * Wrapper method for recaptcha_check_answer.
     *
     * @param string $key
     * @param string $ip
     * @param string $value
     * @return \ReCaptchaResponse
     */
    public function check($ip, $response)
    {
        $arguments = [
            'secret' => $this->privateKey,
            'response' => $response,
            'remoteip' => $ip
        ];

        return $this->request($this->url, $arguments);
    }

    /**
     * Execute a request against the url.
     *
     * @param string $url
     * @param array $params
     */
    public function request($url, array $params = [])
    {
        $url = $url.'?'.http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
