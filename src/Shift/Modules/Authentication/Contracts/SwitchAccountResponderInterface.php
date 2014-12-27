<?php namespace Tectonic\Shift\Modules\Authentication\Contracts; 

interface SwitchAccountResponderInterface
{
    /**
     * @return mixed
     */
    public function onSuccess();

    /**
     * @return mixed
     */
    public function onFailure();
}