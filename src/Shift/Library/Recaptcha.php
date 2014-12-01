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
     * Wrapper method for recaptcha_check_answer.
     *
     * @param string $key
     * @param string $ip
     * @param string $field
     * @param string $value
     * @return \ReCaptchaResponse
     */
    public function checkAnswer($key, $ip, $field, $value)
    {
        return recaptcha_check_answer($key, $ip, $field, $value);
    }
}
