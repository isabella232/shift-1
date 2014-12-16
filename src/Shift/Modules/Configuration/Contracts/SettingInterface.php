<?php
namespace Tectonic\Shift\Modules\Configuration\Contracts;

interface SettingInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $key
     * @return void
     */
    public function setKey($key);

    /**
     * @param string $value
     * @return void
     */
    public function setValue($value);
}
