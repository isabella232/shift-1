<?php
namespace Tectonic\Shift\Library\Security;

use Config;
use Tectonic\Shift\Library\Security\HoneyPotBlacklist;
use Request;

/**
 * Wrapper class for vendor/HP_BlackList.class.php
 *
 * tested this this works by doing the following.
 *
 * $ip = "127.1.20.1"; inside allowed() below.
 *
 * change $typeBitThreshold = 1 in HP_BlackList.class.php
 *
 * See http://www.projecthoneypot.org/httpbl_api.php "Test Values"
 *
 */
class HoneyPot
{
    /**
     * The API key required for connecting with the honeypot api.
     *
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Check if the requesting IP is blacklisted
     *
     * Returns
     * @return boolean
     */
    public function allowed()
    {
        if (!$this->apiKey) {
            return true;
        }

        // Since we're behind an ELB, get the IP as reported by X-Forwarded-For HTTP Header
        $ip = Request::server('HTTP_X_FORWARDED_FOR');

        if (!$ip) {
            // If that doesn't exist, get the regular IP. This will almost certainly be the load balancer.
            $ip = Request::ip();
        }

        return HoneyPotBlacklist::allow($ip, $this->apiKey);
    }
}
