<?php
namespace Tectonic\Shift\Library\Recaptcha;
use Curl\Curl;

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
     * Manages the requests to the recaptcha api.
     *
     * @var \Curl\Curl
     */
    private $curl;

    /**
     * @param string $privateKey
     */
    public function __construct(Curl $curl, $privateKey)
    {
        $this->privateKey = $privateKey;
        $this->curl = $curl;
    }

    /**
     * Wrapper method for recaptcha_check_answer.
     *
     * @param string $ip
     * @param string $response
     * @return \ReCaptchaResponse
     */
    public function check($ip, $response)
    {
        $arguments = [
            'secret' => $this->privateKey,
            'response' => $response,
            'remoteip' => $ip
        ];

        $request = $this->request($this->url, $arguments);
        $response = $this->parse($request);

        return $response['success'];
    }

    /**
     * Execute a request against the url.
     *
     * @param string $url
     * @param array  $params
     *
     * @return mixed
     */
    public function request($url, array $params = [])
    {
        $this->curl->get($url, $params);
        $this->curl->setOpt(CURLOPT_RETURNTRANSFER, true);

        $response = $this->curl->response;

        $this->curl->close();

        return $response;
    }

    /**
     * Parse a request response.
     *
     * @param string $request
     * @return mixed
     */
    protected function parse($request)
    {
        return json_decode($request, true);
    }
}
