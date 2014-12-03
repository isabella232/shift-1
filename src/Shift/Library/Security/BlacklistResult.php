<?php
namespace Tectonic\Shift\Library\Security;

/**
 * HP_BlackListResult is an object which holds
 * the result of the HTTP:BL request
 */
class BlacklistResult
{
    public $ip;
    public $activity;
    public $threat;
    public $typeBit;
    public $typeArray;
    public $searchEngineType;
    public $searchEngineTypeCode;
}
