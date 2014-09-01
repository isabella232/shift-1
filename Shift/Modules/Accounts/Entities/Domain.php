<?php

namespace Tectonic\Shift\Modules\Accounts\Entities;

class Domain
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $domain;


    private $accountId;
}
